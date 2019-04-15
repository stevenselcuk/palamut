<?php
class independentShortcodes {

	public static function independentSoundcloud( $atts ) {
		$atts = shortcode_atts(
			array(
				'url'    => 'https://api.soundcloud.com/tracks/',
				'height' => '',
				'width'  => '',
				'params' => '',
			),
			$atts
		);

		return '<iframe width="' . esc_attr( $atts['width'] ) . '" height="' . esc_attr( $atts['height'] ) . '" scrolling="no" frameborder="no" src="https://w.soundcloud.com/player/?url=' . esc_url( $atts['url'] ) . '&amp;' . esc_url( $atts['params'] ) . '"></iframe>';
	}

	public static function independentVideoIframe( $atts ) {
		$atts = shortcode_atts(
			array(
				'url'    => '',
				'height' => '',
				'width'  => '',
				'params' => '',
			),
			$atts
		);

		return '<iframe width="' . esc_attr( $atts['width'] ) . '" height="' . esc_attr( $atts['height'] ) . '" src="' . esc_url( $atts['url'] ) . '?' . esc_attr( $atts['params'] ) . '" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>';
	}

	public static function independentVideo( $atts ) {
		$atts = shortcode_atts(
			array(
				'url'    => '',
				'height' => '',
				'width'  => '',
			),
			$atts
		);

		return '<video class="independent-custom-video" width="' . esc_attr( $atts['width'] ) . '" height="' . esc_attr( $atts['height'] ) . '" preload="true" style="max-width:100%;">
                    <source src="' . esc_url( $atts['url'] ) . '" type="video/mp4">
                </video>';
	}

	// [crypto_status model="dark" cryptos="bitcoin,ethereum,ripple,bitcoin-cash,eos"]
	public static function independentCryptoStatus( $atts ) {
		$atts_array = shortcode_atts(
			array(
				'cryptos' => 'bitcoin,ethereum,ripple,bitcoin-cash,eos,litecoin,stellar,cardano,iota,tron,tether,neo',
				'model'   => 'light',
			),
			$atts
		);

		extract( $atts_array );

		$cryptos = isset( $cryptos ) ? explode( ',', $cryptos ) : array();
		$model   = isset( $model ) ? ' crypto-' . $model : ' crypto-light';

		if ( false === ( $crypto_json = get_transient( 'crypto_json' ) ) ) {
			// It wasn't there, so regenerate the data and save the transient
			$url         = 'https://api.coinmarketcap.com/v2/ticker/';
			$args        = array( 'timeout' => 500 );
			$response    = wp_remote_get( $url, $args );
			$crypto_json = wp_remote_retrieve_body( $response );

			set_transient( 'crypto_json', $crypto_json, 60 );
		}

		$output      = '';
		$stat_symbol = 'up';

		$crypto_stat_array = json_decode( $crypto_json, true );

		if ( isset( $crypto_stat_array['data'] ) ) {
			$crypto_stat_array = $crypto_stat_array['data'];
			$output           .= '<ul class="nav crypto-slider' . esc_attr( $model ) . '">';
			foreach ( $crypto_stat_array as $key => $crypto ) {
				$crypto_coin_id = isset( $crypto['id'] ) ? $crypto['id'] : '';
				$crypto_id      = isset( $crypto['website_slug'] ) ? $crypto['website_slug'] : '';

				if ( $crypto_id && in_array( $crypto_id, $cryptos ) ) {
					$crypto_name   = isset( $crypto['name'] ) ? $crypto['name'] : '';
					$crypto_symbol = isset( $crypto['symbol'] ) ? $crypto['symbol'] : '';

					$crypto_usd = isset( $crypto['quotes']['USD'] ) ? $crypto['quotes']['USD'] : '';
					if ( $crypto_usd ) {
						$crypto_price = isset( $crypto_usd['price'] ) ? $crypto_usd['price'] : '';
						$crypto_1h    = isset( $crypto_usd['percent_change_1h'] ) ? $crypto_usd['percent_change_1h'] : '';
						$crypto_24h   = isset( $crypto_usd['percent_change_24h'] ) ? $crypto_usd['percent_change_24h'] : '';
						$crypto_7d    = isset( $crypto_usd['percent_change_7d'] ) ? $crypto_usd['percent_change_7d'] : '';
					}

					$stat_symbol            = $crypto_1h < 0 ? 'down' : 'up';
					$output                .= '<li>';
						$output            .= '<div class="media">';
							$output        .= '<div class="media-head mr-2">';
								$output    .= '<img src="' . esc_url( 'https://s2.coinmarketcap.com/static/img/coins/32x32/' . $crypto_coin_id . '.png' ) . '" alt="' . esc_attr( $crypto_symbol ) . '" /><h6 class="crypto-symbol">' . esc_html( $crypto_symbol ) . '</h6>';
								$output    .= '<p class="crypto-usd">' . esc_html( 'USD ' . $crypto_price ) . '</p>';
								$output    .= '<p><i class="fa fa-angle-' . esc_attr( $stat_symbol ) . '"></i> <span class="crypto-1h-percent crypto-stat-' . esc_attr( $stat_symbol ) . '">' . esc_html( $crypto_1h ) . '%</span><span class="last-hour-stat-text">' . esc_html__( '(Last hour status)', 'crypto' ) . '</span></p>';
							$output        .= '</div><!-- .media-head -->';
							$output        .= '<div class="media-body">';
								$output    .= '<h5 class="crypto-symbol">' . esc_html( $crypto_name ) . '</h5>';
								$symbol_24h = $crypto_24h < 0 ? 'down' : 'up';
								$output    .= '<p><i class="fa fa-angle-' . esc_attr( $symbol_24h ) . '"></i> <span class="crypto-24h-percent crypto-stat-' . esc_attr( $symbol_24h ) . '">' . esc_html__( '24 Hours: ' . $crypto_24h ) . '%</span></p>';
								$symbol_7d  = $crypto_7d < 0 ? 'down' : 'up';
								$output    .= '<p><i class="fa fa-angle-' . esc_attr( $symbol_7d ) . '"></i> <span class="crypto-7d-percent crypto-stat-' . esc_attr( $symbol_7d ) . '">' . esc_html__( '7 Days: ' . $crypto_7d ) . '%</span></p>';
							$output        .= '</div><!-- .media-body -->';
						$output            .= '</div><!-- .media -->';
					$output                .= '</li>';
				}
			}
			$output .= '</ul>';
		}
		wp_enqueue_script( 'endlessRiver' );
		return $output;
	}

	// [crypto_status model="dark" cryptos="bitcoin,ethereum,ripple,bitcoin-cash,eos"]
	public static function independentCryptoShortStatus( $atts ) {
		$atts_array = shortcode_atts(
			array(
				'cryptos' => 'bitcoin,ethereum,ripple,bitcoin-cash,dash,eos,litecoin,stellar,cardano,iota,tron,tether,neo,zcash,dogecoin,maker,iota',
				'model'   => 'light',
			),
			$atts
		);

		extract( $atts_array );

		$cryptos = isset( $cryptos ) ? explode( ',', $cryptos ) : array();
		$model   = isset( $model ) ? ' crypto-' . $model : ' crypto-light';

		if ( false === ( $crypto_json = get_transient( 'crypto_json' ) ) ) {
			// It wasn't there, so regenerate the data and save the transient
			$url         = 'https://api.coinmarketcap.com/v2/ticker/';
			$args        = array( 'timeout' => 1200 );
			$response    = wp_remote_get( $url, $args );
			$crypto_json = wp_remote_retrieve_body( $response );

			set_transient( 'crypto_json', $crypto_json, 60 );
		}

		$output      = '';
		$stat_symbol = 'up';

		$crypto_stat_array = json_decode( $crypto_json, true );

		if ( isset( $crypto_stat_array['data'] ) ) {
			$crypto_stat_array = $crypto_stat_array['data'];
			$output           .= '<ul class="nav crypto-slider' . esc_attr( $model ) . '">';
			foreach ( $crypto_stat_array as $key => $crypto ) {
				$crypto_coin_id = isset( $crypto['id'] ) ? $crypto['id'] : '';
				$crypto_id      = isset( $crypto['website_slug'] ) ? $crypto['website_slug'] : '';

				if ( $crypto_id && in_array( $crypto_id, $cryptos ) ) {
					$crypto_name   = isset( $crypto['name'] ) ? $crypto['name'] : '';
					$crypto_symbol = isset( $crypto['symbol'] ) ? $crypto['symbol'] : '';

					$crypto_usd = isset( $crypto['quotes']['USD'] ) ? $crypto['quotes']['USD'] : '';
					if ( $crypto_usd ) {
						$crypto_price = isset( $crypto_usd['price'] ) ? $crypto_usd['price'] : '';
						if ( is_float( $crypto_price ) ) {
							$crypto_price = number_format( (float) $crypto_price, 2, '.', '' );
						}
						$crypto_1h = isset( $crypto_usd['percent_change_1h'] ) ? $crypto_usd['percent_change_1h'] : '';
					}

					$stat_symbol     = $crypto_1h < 0 ? 'down' : 'up';
					$output         .= '<li>';
						$output     .= '<div class="crypto-container">';
							$output .= '<div class="crypto-short-info">';

									$output .= '<img src="' . esc_url( 'https://s2.coinmarketcap.com/static/img/coins/32x32/' . $crypto_coin_id . '.png' ) . '" alt="' . esc_attr( $crypto_symbol ) . '" /><h6 class="crypto-symbol mb-0">' . esc_html( $crypto_name ) . '(' . esc_html( $crypto_symbol ) . ')</h6>';
									$output .= '<span class="crypto-usd">' . esc_html( '$ ' . $crypto_price ) . '</span>';
									$output .= '<span class="crypto-1h-percent crypto-stat-' . esc_attr( $stat_symbol ) . '"><i class="fa fa-angle-' . esc_attr( $stat_symbol ) . '"></i> ' . esc_html( $crypto_1h ) . '%</span></p>';

								$output .= '</div><!-- .crypto-short-info -->';
							$output     .= '</div><!-- .crypto-short-info -->';
					$output             .= '</li>';
				}
			}
			$output .= '</ul>';
		}
		wp_enqueue_script( 'endlessRiver' );
		return $output;
	}

	// [crypto_chart theme="light" cash="false"]
	public static function independentCryptoChart( $atts ) {
		$atts_array = shortcode_atts(
			array(
				'theme' => 'light',
				'cash'  => 'false',
			),
			$atts
		);

		extract( $atts_array );

		$theme    = isset( $theme ) ? $theme : 'light';
		$currency = isset( $currency ) ? $currency : 'usd';
		$cash     = isset( $cash ) ? $cash : 'false';

		$output = '<div class="btcwdgt-chart" bw-theme="' . esc_attr( $theme ) . '" bw-cash="' . esc_attr( $cash ) . '"></div>';
		wp_enqueue_script( 'bitcoin-js' );
		return $output;

	}

	// [crypto_price theme="light" currency="usd" cash="false"]
	public static function independentCryptoPrice( $atts ) {
		$atts_array = shortcode_atts(
			array(
				'theme'    => 'light',
				'currency' => 'usd',
				'cash'     => 'false',
			),
			$atts
		);

		extract( $atts_array );

		$theme    = isset( $theme ) ? $theme : 'light';
		$currency = isset( $currency ) ? $currency : 'usd';
		$cash     = isset( $cash ) ? $cash : 'false';

		$output .= '<div class="btcwdgt-price" bw-theme="' . esc_attr( $theme ) . '" bw-cash="' . esc_attr( $cash ) . '" bw-cur="' . esc_attr( $currency ) . '"></div>';
		wp_enqueue_script( 'bitcoin-js' );
		return $output;

	}

}
add_shortcode( 'soundcloud', array( 'independentShortcodes', 'independentSoundcloud' ) );
add_shortcode( 'videoframe', array( 'independentShortcodes', 'independentVideoIframe' ) );
add_shortcode( 'video', array( 'independentShortcodes', 'independentVideo' ) );
add_shortcode( 'crypto_status', array( 'independentShortcodes', 'independentCryptoStatus' ) );
add_shortcode( 'crypto_short_status', array( 'independentShortcodes', 'independentCryptoShortStatus' ) );
add_shortcode( 'crypto_chart', array( 'independentShortcodes', 'independentCryptoChart' ) );
add_shortcode( 'crypto_price', array( 'independentShortcodes', 'independentCryptoPrice' ) );
