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

add_filter( 'wp_handle_upload_prefilter', 'xpd_reduz_qualidade_imagem' );


/**
 * Reduce the quality of the image after upload
 *
 * @author XPD
 *
 * @param array $file $_FILES array for a given file.
 * @return array $_FILES array with new file
 */
function xpd_reduz_qualidade_imagem($file) {
  $qualidade = 5;
  if($file['type'] == 'image/jpeg') {
    $novo = imagecreatefromjpeg($file['tmp_name']);
    $novaImagem = imagejpeg($novo, $file['tmp_name'], $qualidade);
  }
  return $file;
}