<!--contact-->

<div class="content">

	<div class="main-1">

		<div class="container">

			<div class="login-page">
                           <?php if(isset($message)) : ?>
                               <div class="login-right validation_errors_success">
                                <?= $message ?>
                              </div>
                             <?php endif; ?>        
			   <div class="account_grid">
					<div class="col-md-6 login-right">

			  			<h3>RETRIEVE PASSWORD</h3>
						 <form action="<?= base_url('sendPasswordChangeEmail');?>"  method="POST">
                                                     
							<div>
                                                                
								<span>Email Address<label>*</label></span>

                                                                <input type="email" required name="email" class="globalInputClass" autocomplete="off"> 

							</div>

							<input type="submit" value="Send" class="acount-btn">

						</form>
                                                <?php if($this->session->flashdata('error')) : ?>
                                                    <div class="login-message">
                                                      <p class="dataNotLogged"><?= $this->session->userdata('error')?></p>
                                                    </div>
                                               <?php endif; ?>        
					</div>	

					<div class="clearfix"> </div>

				</div>

			</div>

		</div>

	</div>

</div>

<!-- forgot_password -->