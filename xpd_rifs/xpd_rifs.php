<?php
/*
Plugin Name: XPD Reduce Image File Size (xpd_rifs)
Plugin URI: http://www.xpd.com.br
Description: Reduce Image File Size
Version: 1.0
Author: fzmaster @ XPD
Author URI: http://www.fzmaster.com
License: Use freely
*/

if (function_exists('xpd_reduz_qualidade_imagem_process')) {
  add_filter( 'wp_handle_upload_prefilter', 'xpd_reduz_qualidade_imagem_process' );
}


/**
 * Reduce the quality of the image after upload
 *
 * @author XPD
 *
 * @param array $file $_FILES array for a given file.
 * @return array $_FILES array with new file
 */
function xpd_reduz_qualidade_imagem_process($file) {
  $qualidade = get_option( 'xpd_reduz_qualidade_imagem_config', 100 );
  if($file['type'] == 'image/jpeg') {
    $novo = imagecreatefromjpeg($file['tmp_name']);
    $novaImagem = imagejpeg($novo, $file['tmp_name'], $qualidade);
  }
  return $file;
}

add_action('admin_menu', 'xpd_reduz_qualidade_imagem_menu');

function xpd_reduz_qualidade_imagem_menu() {
  add_options_page( 'XPD Image Quality', 'XPD Image Quality', 'manage_options', 'xpd_reduz_qualidade_imagem_menu', 'xpd_reduz_qualidade_imagem_menu_info');
}

function xpd_reduz_qualidade_imagem_menu_info() {
	if ( !current_user_can( 'manage_options' ) )  {
		wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
	}
  
  $mensagem = '';
  if(sizeof($_POST)) {
    $salvar = $_POST['xpd_reduz_qualidade_imagem_config'];
    //salva dados e redireciona
    if($salvar > 0 or $salvar <= 100) {
      update_option( 'xpd_reduz_qualidade_imagem_config', $_POST['xpd_reduz_qualidade_imagem_config'] );
      $mensagem = 'Salvo com sucesso.';
    } else {
      $mensagem = 'Erro ao salvar.';
    }
  }
  
	echo '<div class="wrap">';
  screen_icon();
  echo '<h1>Configurar qualidade da imagem</h1>';
  echo $mensagem;
	echo '<p>Insira a qualidade em percentagem para auto compacta&ccedil;&atilde;o da imagem.</p>';
  $opt_val = get_option( 'xpd_reduz_qualidade_imagem_config', 100 );
?>
<form name="" method="post" action="">
<p>Qualidade:
<input type="text" name="xpd_reduz_qualidade_imagem_config" value="<?php echo $opt_val; ?>" size="20" /> %
</p><hr />
<p class="submit">
<input type="submit" name="Submit" class="button-primary" value="<?php esc_attr_e('Save Changes') ?>" />
</p>
</form>
<?php
	echo '</div>';
}
