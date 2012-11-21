<?php 
session_start();
if(!isset($_SESSION['userid'])){
	header('Location: subscribe.php'); 
	exit;
}
?>

<?php 
require_once('models/questions.php');
require_once('models/question.php');
require_once('models/choice.php');

require_once('includes/create_conn.php');

$questions = Questions::retrieveAll($conn);
?>

<!DOCTYPE html>

<html xmlns="http://www.w3.org/1999/xhtml"
      xmlns:og="http://ogp.me/ns#"
      xmlns:fb="http://www.facebook.com/2008/fbml">

<head profile="http://www.w3.org/2005/10/profile">
<link rel="icon" 
      type="image/png" 
      href="./favicon.png">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<meta name="title" content="Cafe Diem, comming soon" />
	<meta name="description" content="Cafe Diem, comming soon" />
	
	<meta property="og:title" content="Cafe Diem: win an invitation for two" />
	<meta property="og:type" content="restaurant" />
	<meta property="og:url" content="http://cafediem.com" />
	<meta property="og:image" content="http://www.cafediem.com/logo-banner-no-data.gif" />
	<meta property="og:site_name" content="Cafe Diem" />
	<meta property="og:description" content="Cafe Diem comming soon" />
	<meta property="fb:admins" content="801915383" />
	
	<link type="text/css" rel="stylesheet" href="css/reset.css" />
	<link type="text/css" rel="stylesheet" href="css/main.css" />

	<script type="text/javascript" src="js/jquery.js"></script>
	<script type="text/javascript" src="js/jquery.scrollTo-1.4.3.1-min.js"></script>
	<script type="text/javascript" src="js/jquery.bpopup-0.7.0.min.js"></script>
	<script type="text/javascript" src="js/main.js"></script>

	<link rel="shortcut icon" href="./favicon.png" />

	<title>CafeDiem Comming soon</title>
</head>

<body>

	<div class="main" id="quiz">
		<div id="wrapper">
			<div id="questions">
				<div class="batch">
					<p class="error">Please answer all the questions before proceeding <a class="close" href="#">x</a></p>

					<?php
						$i=0;
						foreach($questions as $question):
							$i++;
							$sQuestion = $question->getQuestion();
							$type = $question->getType();
							$id = $question->getId();
					?>

							<div class="question">
								<dl>
									<dt>
										<div class="left"><?php printf('%02d',$i); ?></div>
										<div class="right"><h2><?php echo $sQuestion; ?></h2></div>
									</dt>
									<dd>
										

										<?php if($type == 'open'): ?>
											<textarea placeholder="Answer goes here..." name="<?php echo $id; ?>"></textarea>
										<?php else: ?>

											<select 
													name="<?php echo $id; ?>" 
													id="<?php echo $id; ?>"
													class="choices" 
													<?php if($type == 'multichoice')  
																echo "multiple size='2' style='height:86px'"; ?>
											>
												<?php 
													$choices = $question->getChoices($conn);
													$ulContent = '';
												?>

												<option style="color:#ccc;" value="0" selected="selected">
													Choose answer
												</option>

												<?php foreach($choices as $choice): ?>
													<?php $answer = ucwords(html_entity_decode($choice->getAnswer())); ?>
													<option value="<?php echo $choice->getId(); ?>">
														<?php echo $answer; ?>
													</option>
													<?php $ulContent .= "<li id='".$choice->getId()."'><a href='#'>{$answer}</a></li>"; ?>
												<?php endforeach; ?>

												<?php if($i <= 2): ?>
													<!-- <option class="other" value="other">Other</option> -->
													<?php $ulContent .= "<li><input type='text' class='other' placeholder='other' /></li>"; ?>
												<?php endif; ?>

											</select>

											<ul class='<?php if(stripos($sQuestion, 'pay for meal') !== false) echo "arrange-cubic" ?>
													  <?php if($type == 'multichoice') echo " multi-2" ?>'>
												<?php echo $ulContent; ?>
											</ul>

										<?php endif; ?>

									</dd>
								</dl>
							</div>

							<?php if($i == 9): ?>

								</div> <!-- END of (first) .batch -->

								<div class="batch">
									<p class="error close">Please answer all the questions before proceeding <a href="#">x</a></p>

							<?php endif; ?>

					<?php endforeach; ?>

				

					<div class="socials">
						<div class="m-default">
							<div class="logo-quiz">
								<p>AAAND WE’RE DONE!</p>
								<input type="button" id="submit" value="Did I win?" />
							</div>
						</div>

						<div class="winner">
							<h2>
								WOW! Talk about seizing the day<br />
								We'll call you as soon as we open<br /> 
								Congrats!
							</h2>
							<h3>tell your friends</h3>

							<ul>
								<li>
									<a rel="0" class="facebook" href="http://www.facebook.com/share.php?u=http%3A%2F%2Fcafediem.com&t=test" target="_blank">

									</a>
								</li>
								<li>
									<a rel="1" class="twitter" href="https://twitter.com/intent/tweet?text=Win+two+invitation+for+cafe+Diem%3A&url=http%3A%2F%2Fcafediem.com" target="_blank">

									</a>
								</li>
							</ul>
						</div>

						<div class="loose">
							<h2>We're sorry you've lost!</h2>
							<p
								style="font-size: 28px;text-transform: uppercase;margin-bottom: 24px;"
							>
								We promise to make it<br />  up to you
								with heavenly<br /> treats when you visit us
							</p>
							
							<h3>tell your friends</h3>

							<ul>
								<li>
									<a rel="0" class="facebook" href="http://www.facebook.com/share.php?u=http%3A%2F%2Fcafediem.com&t=test" target="_blank">
										<img src="images/facebook.png">
									</a>
								</li>
								<li>
									<a rel="1" class="twitter" href="https://twitter.com/intent/tweet?text=Win+two+invitation+for+cafe+Diem%3A&url=http%3A%2F%2Fcafediem.com" target="_blank">
										<img src="images/twitter.png">
									</a>
								</li>
							</ul>
						</div>
					</div> <!-- END .socials -->

					
				</div> <!-- END of (second and last) .batch -->
				<div class="clear"></div>
			</div><!-- END #questions -->
		</div><!-- END #wrapper -->
		<div class="clear"></div>
	</div><!-- END  .main -->

	<div class="link-btn footer">
		<a href="quiz.php">one more batch to go! <span style="font-family:arial, sans-serif; font-size:52px;">&rsaquo;</span></a>
	</div>
	
</body>

</html>