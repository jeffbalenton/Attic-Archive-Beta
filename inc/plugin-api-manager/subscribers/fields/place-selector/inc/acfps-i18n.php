<?php
    /**
     * Get country name + i18n country names
     *
     * These are defined here so they are 'picked up' as translatable strings, because not all values occur in the plugin itself.
     *
     * @param $country_code
     *
     * @since 0.29.0
     *
     * @return mixed
     */
    function acfps_country_i18n( $country_code ) {

        $country_array = array(
            'ad'     => esc_html__( 'Andorra', 'acf-place-selector' ),
            'aw'     => esc_html__( 'Aruba', 'acf-place-selector' ),
            'at'     => esc_html__( 'Austria', 'acf-place-selector' ),
            'au'     => esc_html__( 'Australia', 'acf-place-selector' ),
            'br'     => esc_html__( 'Brazil', 'acf-place-selector' ),
            'ca'     => esc_html__( 'Canada', 'acf-place-selector' ),
            'cn'     => esc_html__( 'China', 'acf-place-selector' ),
            'cw'     => esc_html__( 'Curaçao', 'acf-place-selector' ),
            'europe' => esc_html__( 'Europe', 'acf-place-selector' ),
            'fr'     => esc_html__( 'France', 'acf-place-selector' ),
            'de'     => esc_html__( 'Germany', 'acf-place-selector' ),
            'gd'     => esc_html__( 'Grenada', 'acf-place-selector' ),
            'gb'     => esc_html__( 'Great Britain', 'acf-place-selector' ),
            'lu'     => esc_html__( 'Luxembourg', 'acf-place-selector' ),
            'mx'     => esc_html__( 'Mexico', 'acf-place-selector' ),
            'nz'     => esc_html__( 'New Zealand', 'acf-place-selector' ),
            'pt'     => esc_html__( 'Portugal', 'acf-place-selector' ),
            'kr'     => esc_html__( 'South Korea', 'acf-place-selector' ),
            'es'     => esc_html__( 'Spain', 'acf-place-selector' ),
            'ch'     => esc_html__( 'Switzerland', 'acf-place-selector' ),
            'us'     => esc_html__( 'United States', 'acf-place-selector' ),
            'uy'     => esc_html__( 'Uruguay', 'acf-place-selector' ),
            'world'  => esc_html__( 'World', 'acf-place-selector' ),
        );

        if ( $country_code && array_key_exists( $country_code, $country_array ) ) {
            return $country_array[ $country_code ];
        }

        return $country_code;
    }
