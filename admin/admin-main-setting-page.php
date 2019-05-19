<?php
/*
 Main Setting Page  _ ExUnit > メイン設定 メニューを追加
 Main Setting Page  _ ページのフレーム（ メニューとメインエリア両方 ）
 Main Setting Page  _ メインエリアの中身



/*
 Main Setting Page  _ ExUnit > メイン設定 メニューを追加
/*-------------------------------------------*/
function veu_add_main_setting() {
	// $capability_required = veu_get_capability_required();
	$custom_page = add_submenu_page(
		'vkExUnit_setting_page',            // parent
		__( 'Main setting', 'vk-all-in-one-expansion-unit' ),   // Name of page
		__( 'Main setting', 'vk-all-in-one-expansion-unit' ),   // Label in menu
		'activate_plugins',                         // veu_get_capability_required()でないのは edit_theme_options権限を付与したユーザーにもアクセスさせないためにactivate_pluginsにしている。
		// $capability_required,		// Capability
		'vkExUnit_main_setting',        // ユニークなこのサブメニューページの識別子
		'veu_render_main_frame'         // メニューページのコンテンツを出力する関数
	);
	if ( ! $custom_page ) {
		return; }
}
add_action( 'admin_menu', 'veu_add_main_setting' );


/*
 Main Setting Page  _ ページのフレーム（ メニューとメインエリア両方 ）
/*-------------------------------------------*/
function veu_render_main_frame() {

	// nonce
	if ( isset( $_POST['_nonce_vkExUnit'] ) && wp_verify_nonce( $_POST['_nonce_vkExUnit'], 'standing_on_the_shoulder_of_giants' ) ) {
		// sanitize & update
		veu_main_sanitaize_and_update( $_POST );
	}

	// Left menu area top Title
	$get_page_title = veu_get_little_short_name() . ' Main setting';

	// Left menu area top logo
	$get_logo_html = veu_get_systemlogo_html();

	// $menu
	/*--------------------------------------------------*/
	global $vkExUnit_options;
	if ( ! isset( $vkExUnit_options ) ) {
		$vkExUnit_options = array();
	}
	$get_menu_html = '';

	foreach ( $vkExUnit_options as $vkoption ) {
		if ( ! isset( $vkoption['render_page'] ) ) {
			continue; }
		// $linkUrl = ($i == 0) ? 'wpwrap':$vkoption['option_name'];
		$linkUrl        = $vkoption['option_name'];
		$get_menu_html .= '<li id="btn_"' . $vkoption['option_name'] . '" class="' . $vkoption['option_name'] . '"><a href="#' . $linkUrl . '">';
		$get_menu_html .= $vkoption['tab_label'];
		$get_menu_html .= '</a></li>';
	}

	Vk_Admin::admin_page_frame( $get_page_title, 'vkExUnit_the_main_setting_body', $get_logo_html, $get_menu_html );

}

/*
 Main Setting Page  _ メインエリアの中身
/*-------------------------------------------*/
function vkExUnit_the_main_setting_body() {
	global $vkExUnit_options;?>
	<form method="post" action="">
	<?php
	wp_nonce_field( 'standing_on_the_shoulder_of_giants', '_nonce_vkExUnit' );
	if ( is_array( $vkExUnit_options ) ) {
		echo '<div>'; // jsでfirst-child取得用
		foreach ( $vkExUnit_options as $vkoption ) {

			if ( empty( $vkoption['render_page'] ) ) {
				continue; }

			echo '<section id="' . $vkoption['option_name'] . '">';

			call_user_func_array( $vkoption['render_page'], array() );

			echo '</section>';
		}
		echo '</div>';

	} else {

		echo  __( 'Activated Packages is noting. please activate some package.', 'vk-all-in-one-expansion-unit' );

	}
	echo  '</form>';
}

function vkExUnit_register_setting( $tab_label = 'tab_label', $option_name, $sanitize_callback, $render_page ) {
	global $vkExUnit_options;
	if ( ! isset( $vkExUnit_options ) ) {
		$vkExUnit_options = array();
	}
	$vkExUnit_options[] =
		array(
			'option_name' => $option_name,
			'callback'    => $sanitize_callback,
			'tab_label'   => $tab_label,
			'render_page' => $render_page,
		);
}

/*
 Main Setting Page  _ 値をアップデート
/*-------------------------------------------*/
function veu_main_sanitaize_and_update( $post ) {
	global $vkExUnit_options;

	if ( ! empty( $vkExUnit_options ) ) {

		// $vkExUnit_options をループしながらサニタイズ＆アップデートする
		foreach ( $vkExUnit_options as $opt ) {

			// サニタイズ Call back が登録されている場合にサニタイズ実行
			if ( ! empty( $opt['callback'] ) ) {

				// コールバック関数にわたすパラメーターを指定
				$before = ( ! empty( $post[ $opt['option_name'] ] ) ? $post[ $opt['option_name'] ] : null );

				// サニタイズコールバックを実行
				$option = call_user_func_array( $opt['callback'], array( $before ) );
			}

			update_option( $opt['option_name'], $option );
		}
	}
}

/*
global $vkExUnit_options に各種値を登録するための関数
 */
function vkExUnit_register_setting( $tab_label = 'tab_label', $option_name, $sanitize_callback, $render_page ) {
	global $vkExUnit_options;
	if ( ! isset( $vkExUnit_options ) ) {
		$vkExUnit_options = array();
	}
	$vkExUnit_options[] =
		array(
			'option_name' => $option_name,
			'callback'    => $sanitize_callback,
			'tab_label'   => $tab_label,
			'render_page' => $render_page,
		);
}
