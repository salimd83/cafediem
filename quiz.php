<?php session_start() ?>

<?php 
if(!isset($_SESSION['userid'])){
	header('Location: subscribe.php'); exit;
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

<html>

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<link type="text/css" rel="stylesheet" href="css/reset.css" />
	<link type="text/css" rel="stylesheet" href="css/main.css" />

	<script type="text/javascript" src="js/jquery.js"></script>
	<script type="text/javascript" src="js/jquery.scrollTo-1.4.3.1-min.js">
	</script>
	<script type="text/javascript" src="js/main.js"></script>

	<title>Title goes here</title>
</head>

<body>

	<div class="main" id="quiz">
		<div id="wrapper">
			<div id="questions">
				<div class="batch">
					<p class="error"></p>

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
									<p class="error"></p>

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
								Congratulations!<br />
								You’ve won an<br />
								invitation for two!
							</h2>
							<p>We’re emailing you with details,<br /> meanwhile...</p>
							<h3>tell your friends!</h3>

							<ul>
								<li>
									<a href="#" target="_blank">
										<img src="images/facebook.png">
									</a>
								</li>
								<li>
									<a href="#" target="_blank">
										<img src="images/twitter.png">
									</a>
								</li>
							</ul>
						</div>

						<div class="loose">
							<h2>
								Sorry<br />
								You’ve won an<br />
								invitation for two!
							</h2>
							<p>We’re emailing you with details,<br /> meanwhile...</p>
							<h3>tell your friends!</h3>

							<ul>
								<li>
									<a href="#" target="_blank">
										<img src="images/facebook.png">
									</a>
								</li>
								<li>
									<a href="#" target="_blank">
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