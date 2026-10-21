<?php
/**
 * @version 10.4.0
 */

defined( 'ABSPATH' ) || exit;

$email        = $email ?? null;
$crea_socials = array_filter(
	array(
		'Facebook'  => crea_legacy_mod( 'facebook_url' ),
		'Instagram' => crea_legacy_mod( 'instagram_url' ),
	)
);
?>
																		</div>
																	</td>
																</tr>
															</table>
														</td>
													</tr>
												</table>
											</td>
										</tr>
									</table>
								</td>
							</tr>
							<tr>
								<td align="center" valign="top">
									<table border="0" cellpadding="10" cellspacing="0" width="100%" id="template_footer" role="presentation">
										<tr>
											<td valign="top">
												<table border="0" cellpadding="10" cellspacing="0" width="100%" role="presentation">
													<tr>
														<td colspan="2" valign="middle" id="credit">
															<?php echo wp_kses_post( wpautop( wptexturize( apply_filters( 'woocommerce_email_footer_text', get_option( 'woocommerce_email_footer_text' ), $email ) ) ) ); ?>
															<?php if ( $crea_socials ) : ?>
																<p class="crea-email-socials">
																	<?php foreach ( $crea_socials as $crea_name => $crea_url ) : ?>
																		<a href="<?php echo esc_url( $crea_url ); ?>"><?php echo esc_html( $crea_name ); ?></a>
																	<?php endforeach; ?>
																</p>
															<?php endif; ?>
														</td>
													</tr>
												</table>
											</td>
										</tr>
									</table>
								</td>
							</tr>
						</table>
					</div>
				</td>
				<td></td>
			</tr>
		</table>
	</body>
</html>
