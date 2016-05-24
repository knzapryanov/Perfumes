<!--contact-->

<div class="content">

	<div class="main-1">

		<div class="container">

			<div class="login-page">
                            
                              <?php if(isset($message)) : ?>
                               <div class="login-right validation_errors">
                                <?= $message ?>
                              </div>
                             <?php endif; ?>   
			   <div class="account_grid">
					<div class="col-md-6 login-right">

			  			<h3>CHANGE PASSWORD</h3>
						 <form action="<?= base_url('changePassword');?>"  method="POST">                                                    

							<div>

								<span>New Password<label>*</label></span>

								<input type="password" name="password" autocomplete="off"> 

							</div>
							<div>

								<span>Password confirm<label>*</label></span>

								<input type="password" name="password" autocomplete="off"> 

							</div>

							<input type="submit" value="Change" class="change-pass-btn">

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