<!--contact-->

<div class="content">

	<div class="main-1">

		<div class="container">

			<div class="login-page">
			   <div class="account_grid">

					<div class="col-md-6 login-right">

			  			<h3>Control Panel</h3>

						 <form action="<?= base_url('admin/checkRole');?>"  method="POST">

							<div>

								<span>Email Address<label>*</label></span>

                                                                <input type="text" name="email" autocomplete="off"> 

							</div>

							<div>

								<span>Password<label>*</label></span>

								<input type="password" name="password" autocomplete="off"> 

							</div>

							<input type="submit" value="Login" class="acount-btn">

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

<!-- login -->