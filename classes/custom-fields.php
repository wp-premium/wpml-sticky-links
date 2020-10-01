<?php

namespace WPML\SL;

class CustomFields implements \IWPML_Backend_Action, \IWPML_DIC_Action {

	/**
	 * @var array
	 */
	private $metaKeys;

	/**
	 * @var \AbsoluteLinks
	 */
	private $absoluteLinks;

	/**
	 * @var \WPML_Absolute_To_Permalinks
	 */
	private $absoluteToPermalinks;

	/**
	 * Class constructor.
	 *
	 * @param \AbsoluteLinks               $absoluteLinks
	 * @param \WPML_Absolute_To_Permalinks $absoluteToPermalinks
	 */
	public function __construct( \AbsoluteLinks $absoluteLinks, \WPML_Absolute_To_Permalinks $absoluteToPermalinks ) {
		$this->absoluteLinks        = $absoluteLinks;
		$this->absoluteToPermalinks = $absoluteToPermalinks;
	}

	/**
	 * Add hooks.
	 */
	public function add_hooks() {
		add_action( 'wpml_sl_converted_urls', [ $this, 'convertUrlsInCustomFields' ] );
		add_action( 'wpml_sl_reverted_urls', [ $this, 'revertUrlsInCustomFields' ] );

		$this->addMetaHooks();
	}

	/**
	 * Add hooks for custom fields.
	 */
	private function addMetaHooks() {
		add_action( 'updated_post_meta', [ $this, 'convertUrlsInCustomField' ], 10, 4 );
		add_action( 'added_post_meta', [ $this, 'convertUrlsInCustomField' ], 10, 4 );
	}

	/**
	 * Remove hooks for custom fields.
	 */
	private function removeMetaHooks() {
		remove_action( 'updated_post_meta', [ $this, 'convertUrlsInCustomField' ], 10 );
		remove_action( 'added_post_meta', [ $this, 'convertUrlsInCustomField' ], 10 );
	}

	/**
	 * Scan a post to convert urls in custom fields.
	 *
	 * @param int $post_id The post ID we are updating.
	 */
	public function convertUrlsInCustomFields( $post_id ) {
		$meta = get_post_meta( $post_id );
		foreach ( $meta as $key => $values ) {
			foreach ( $values as $value ) {
				$value = maybe_unserialize( $value );
				$this->convertUrlsInCustomField( null, $post_id, $key, $value );
			}
		}
	}

	/**
	 * Convert links to default format in the custom fields configured to do so.
	 *
	 * @param int    $metaId The primary key (not used here).
	 * @param int    $id     The post ID we are updating.
	 * @param string $key    The custom field we are updating.
	 * @param string $value  The value of the custom field.
	 */
	public function convertUrlsInCustomField( $metaId, $id, $key, $value ) {
		$metaKeys = $this->getSettings();

		if ( false === array_key_exists( $key, $metaKeys ) ) {
			return;
		}

		$alpBrokenLinks = [];
		$newValue       = $this->recursively_process_generic_text( $value, $alpBrokenLinks );

		if ( $newValue !== $value ) {
			$this->removeMetaHooks();
			update_post_meta( $id, $key, $newValue, $value );
			$this->addMetaHooks();
		}
	}

	/**
	 * Recursively process custom field contents to convert links.
	 *
	 * @param mixed $value
	 * @param array $alpBrokenLinks
	 */
	private function recursively_process_generic_text( $value, &$alpBrokenLinks ) {
		if ( is_array( $value ) ) {
			foreach ( $value as $key => $row ) {
				$value[ $key ] = $this->recursively_process_generic_text( $row, $alpBrokenLinks );
			}
		} elseif ( is_string( $value ) ) {
			$value = $this->absoluteLinks->_process_generic_text( $value, $alpBrokenLinks );
		}

		return $value;
	}

	/**
	 * Revert to permalinks in custom fields.
	 *
	 * @param int $post_id The post ID we are updating.
	 */
	public function revertUrlsInCustomFields( $post_id ) {
		$this->removeMetaHooks();

		$metaKeys = $this->getSettings();
		$meta     = get_post_meta( $post_id );
		foreach ( $metaKeys as $metaKey => $status ) {
			if ( isset( $meta[ $metaKey ] ) && $status ) {
				foreach ( $meta[ $metaKey ] as $value ) {
					$value    = maybe_unserialize( $value );
					$newValue = $this->recursively_convert_text( $value );
					if ( $newValue !== $value ) {
						update_post_meta( $post_id, $metaKey, $newValue, $value );
					}
				}
			}
		}

		$this->addMetaHooks();
	}

	/**
	 * Recursively process custom field contents to revert links.
	 *
	 * @param mixed $value
	 * @return mixed
	 */
	private function recursively_convert_text( $value ) {
		if ( is_array( $value ) ) {
			foreach ( $value as $key => $row ) {
				$value[ $key ] = $this->recursively_convert_text( $row );
			}
		} elseif ( is_string( $value ) ) {
			$value = $this->absoluteToPermalinks->convert_text( $value );
		}

		return $value;
	}

	/**
	 * Gets a list of custom fields that are configured as `convert_to_sticky`.
	 *
	 * @return array
	 */
	private function getSettings() {
		if ( null === $this->metaKeys ) {
			$this->metaKeys = [];
			$settings       = apply_filters( 'wpml_setting', false, 'translation-management' );
			if ( array_key_exists( 'custom_fields_convert_to_sticky', $settings ) ) {
				$this->metaKeys = $settings['custom_fields_convert_to_sticky'];
			}
		}

		return $this->metaKeys;
	}

}
