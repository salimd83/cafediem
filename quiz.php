<?php session_start() ?>

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

												<?php if($type != 'multichoice'): ?>
													<option style="color:#ccc;" selected="selected" value="0">
														Choose answer
													</option>
												<?php endif; ?>

												<?php foreach($choices as $choice): ?>
													<?php $answer = ucwords(html_entity_decode($choice->getAnswer())); ?>
													<option value="<?php echo $choice->getId(); ?>">
														<?php echo $answer; ?>
													</option>
													<?php $ulContent .= "<li><a href='#'>{$answer}</a></li>"; ?>
												<?php endforeach; ?>

												<?php if($i <= 2): ?>
													<option class="other" value="other">Other</option>
													<?php $ulContent .= "<li><input type='text' placeholder='other' /></li>"; ?>
												<?php endif; ?>

											</select>

										<?php endif; ?>

										<ul <?php if(stripos($sQuestion, 'pay for meal') !== false) echo "class='arrange-cubic'" ?>>
											<?php echo $ulContent; ?>
										</ul>
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
								<a href="index.php" style="display:block; height:339px;">
									<img src="images/end-of-quiz-home.gif"
										 width="462"
										 height="339" />
								</a>

								<a href="#" id="end-quiz">
									<!-- <img src="images/end-of-quiz-socials.gif" /> -->
								</a>
							</div>
						</div>
						<div class="m-over">
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

					<input type="button" id="submit" value="Submit Answers" />
				</div> <!-- END of (second and last) .batch -->
				<div class="clear"></div>
			</div><!-- END #questions -->
		</div><!-- END #wrapper -->
		<div class="clear"></div>
	</div><!-- END  .main -->

	<div class="link-btn footer">
		<a href="quiz.php">Start Here</a>
	</div>

</body>

</html>