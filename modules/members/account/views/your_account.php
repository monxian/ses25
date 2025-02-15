<section class="main-sec">
	<div class="container cont-sm">
		<div class="container-header pb8 flex align-center justify-between">
			<div>
				<h2>Your Account</h2>
			</div>
		</div>
		<div>
			<div>
				<div class="pb4">Options</div>
			</div>
			<div class="flex flex-col">
				<?php
				echo anchor(
					'members-account/update/' . $code,
					'<svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 24 24">
									<path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M10.5 22H6.59c-1.545 0-2.774-.752-3.877-1.803c-2.26-2.153 1.45-3.873 2.865-4.715c2.55-1.52 5.628-1.87 8.422-1.054M16.5 6.5a4.5 4.5 0 1 1-9 0a4.5 4.5 0 0 1 9 0m1.933 7.349c.335-.364.503-.546.681-.652a1.4 1.4 0 0 1 1.397-.02c.18.1.354.277.7.63c.345.353.518.53.616.714c.238.447.23.988-.02 1.427c-.104.182-.282.353-.638.696l-4.231 4.075c-.674.65-1.011.974-1.432 1.139c-.421.164-.885.152-1.81.128l-.127-.003c-.282-.008-.422-.012-.504-.105s-.071-.236-.049-.523l.012-.156c.063-.808.095-1.213.253-1.576c.157-.363.43-.658.974-1.248z" color="currentColor" />
								</svg>&nbsp; Update Your Details',
					array("class" => "button btn-primary-45 mb8  flex align-center")
				);
				echo anchor('members-account/update_password', '<svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 24 24">
							<g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" color="currentColor">
								<path d="M13.993 15H14m-4 0h.007M5 15a7 7 0 1 1 14 0a7 7 0 0 1-14 0" />
								<path d="M16.5 9.5v-3a4.5 4.5 0 1 0-9 0v3" />
							</g>
					    	</svg>&nbsp;Update Password', array("class" => "button btn-primary-45 mb8 flex align-center"));
				echo anchor(
					'members-account/signature/',
					'<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
					<path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M22 12.634c-4 3.512-4.572-2.013-6.65-1.617c-2.35.447-3.85 5.428-2.35 5.428s-.5-5.945-2.5-3.89s-2.64 4.74-4.265 2.748C-1.5 5.813 5-1.15 8.163 3.457C10.165 6.373 6.5 16.977 2 22m7-1h10" color="currentColor" />
				</svg>&nbsp; Add/Update Signature',
					array("class" => "button btn-primary-45 mb8  flex align-center")
				);


				echo anchor('members/logout', ' <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                                <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M14 3.095A10 10 0 0 0 12.6 3C7.298 3 3 7.03 3 12s4.298 9 9.6 9q.714 0 1.4-.095M21 12H11m10 0c0-.7-1.994-2.008-2.5-2.5M21 12c0 .7-1.994 2.008-2.5 2.5" color="currentColor" />
                            </svg>&nbsp;Sign Out', array("class" => "button btn-secondary flex align-center"));
				?>
			</div>

			<div class="mt16 bg-secondary p8 round-sm">
				<p class="small-text text-secondary"><i>Year to date hours breakdown</i></p>
				<?php
				echo '<div class="mt8">
					     	<h4>Regular Hours <span class="small-text">(approx. includes lunch time)</span></h4>
							<p class="pt4">' . $hours_summary[0]->reg . '</p>
					      </div>';
				echo '<div class="mt8">
					     	<h4>Vacation Hours</h4>
							<p class="pt4">' . $hours_summary[0]->vaca . '</p>
					      </div>';

				echo '<div class="mt8">
					     	<h4>Holiday Hours</h4>
							<p class="pt4">' . $hours_summary[0]->holiday . '</p>
					      </div>';
				?>
			</div>

			<div>
				<div class="mt16"><span class="small-text text-secondary">Username</span><span class="pl8"><?= ucfirst($member_obj->username) ?></span></div>
				<div><span class="small-text text-secondary">First Name</span><span class="pl8"><?= ucfirst($member_obj->first_name) ?></span></div>
				<div><span class="small-text text-secondary">Last Name</span><span class="pl8"><?= ucfirst($member_obj->last_name) ?></span></div>
				<div><span class="small-text text-secondary">Email Address</span><span class="pl8"><?= $member_obj->email_address ?></span></div>
				<div><span class="small-text text-secondary">Date Joined</span><span class="pl8"><?= date('jS F Y', $member_obj->date_joined) ?></span></div>
			</div>
		</div>
	</div>
</section>
<?= json($data); ?>