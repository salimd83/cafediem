<?php session_start() ?>

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
			<div id="question">
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
					<div>
						<!-- <img src="images/questions/question-1.gif" 
							 alt="Where Do You Live?"
							 width="220"
							 height="129" /> -->
						<!-- <dl>
							<dt><?php printf('%02d',$i); ?></dt>
							<dd><?php echo $sQuestion; ?></dd>
						</dl>
						<ul>
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
									<?php $choices = $question->getChoices($conn); ?>
									<?php if($type != 'multichoice'): ?>
										<option style="color:#ccc;" selected="selected" value="0">
											Choose answer
										</option>
									<?php endif; ?>

									<?php foreach($choices as $choice): ?>
										<option value="<?php echo $choice->getId(); ?>">
											<?php echo ucwords(html_entity_decode($choice->getAnswer())); ?>
										</option>
										<li>
											<a href="#" name="<?php echo $choice->getId(); ?>">
												<?php echo ucwords(html_entity_decode($choice->getAnswer())); ?>
											</a>
										</li>
									<?php endforeach; ?>

									<?php if($i <= 2): ?>
										<li class="other">
											<a href="#" name="<?php echo $choice->getId(); ?>">
												<?php echo ucwords(html_entity_decode($choice->getAnswer())); ?>
											</a>
										</li>
									<?php endif; ?>
								</select>
							<?php endif; ?>
						</ul> -->

						<dl>
							<dt><?php printf('%02d',$i); ?></dt>
							<dd><?php echo $sQuestion; ?></dd>
						</dl>
						<ul>
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
									<?php $choices = $question->getChoices($conn); ?>
									<?php if($type != 'multichoice'): ?>
										<option style="color:#ccc;" selected="selected" value="0">
											Choose answer
										</option>
									<?php endif; ?>

									<?php foreach($choices as $choice): ?>
										<option value="<?php echo $choice->getId(); ?>">
											<?php echo ucwords(html_entity_decode($choice->getAnswer())); ?>
										</option>
										<li>
											<a href="#" name="<?php echo $choice->getId(); ?>">
												<?php echo ucwords(html_entity_decode($choice->getAnswer())); ?>
											</a>
										</li>
									<?php endforeach; ?>
									
									<?php if($i <= 2): ?>
										<li class="other">
											<a href="#" name="<?php echo $choice->getId(); ?>">
												<?php echo ucwords(html_entity_decode($choice->getAnswer())); ?>
											</a>
										</li>
									<?php endif; ?>
								</select>
							<?php endif; ?>
						</ul>
					</div>
				</div> <!-- END of (first) .batch -->

				<div class="batch">
					<p class="error"></p>
					<div>
						<dl>
							<dt>13</dt>
							<dd>what’s your favorite sandwich?</dd>
						</dl>
						<ul>
							<li><a href="#">Chicken Avocado</a></li>
							<li><a href="#">Crab Cocktail</a></li>
							<li><a href="#">Ham & Cheese</a></li>
							<li><a href="#">Halloumi</a></li>
						</ul>
					</div>
					<div>
						<dl>
							<dt>14</dt>
							<dd>what’s your favorite salad?</dd>
						</dl>
						<textarea id="favorite-salad" placeholder="Answer goes here..."></textarea>
					</div>
					<div>
						<dl>
							<dt>15</dt>
							<dd>What’s the best bean used for coffee?</dd>
						</dl>
						<ul>
							<li><a href="#">Arabica</a></li>
							<li><a href="#">Robusta</a></li>
							<li><a href="#">Botanica</a></li>
						</ul>
					</div>
					<div>
						<dl>
							<dt>16</dt>
							<dd>Is cappuccino made from milk or cream?</dd>
						</dl>
						<ul class="two-rows">
							<li><a href="#">Milk</a></li>
							<li><a href="#">Cream</a></li>
						</ul>
					</div>
					<div>
						<dl>
							<dt>17</dt>
							<dd>when was the sandwich invented?</dd>
						</dl>
						<ul>
							<li><a href="#">17<sup>th</sup> Century</a></li>
							<li><a href="#">18<sup>th</sup> Century</a></li>
							<li><a href="#">19<sup>th</sup> Century</a></li>
						</ul>
					</div>
					<div>
						<dl>
							<dt>18</dt>
							<dd>what item do you rarely find in a salad bar?</dd>
						</dl>
						<textarea id="favorite-salad" 
								  placeholder="Answer goes here...">
						</textarea>
					</div>
					<div>
						<dl>
							<dt>19</dt>
							<dd>what’s the difference between organic 
								and natural?</dd>
						</dl>
						<textarea id="favorite-salad" 
								  placeholder="Answer goes here...">
						</textarea>
					</div>
					<div>
						<dl>
							<dt>20</dt>
							<dd>What wine goes best with cheese?</dd>
						</dl>
						<ul>
							<li><a href="#">Red Wine</a></li>
							<li><a href="#">White Wine</a></li>
							<li><a href="#">Rosé Wine</a></li>
							<li><a href="#">Sparkling Wine</a></li>
						</ul>
					</div>
					<div>
						<dl>
							<dt>21</dt>
							<dd>what’s the difference between creme caramel 
								and creme brulee?</dd>
						</dl>
						<textarea id="favorite-salad" 
								  placeholder="Answer goes here...">
						</textarea>
					</div>
					<div>
						<dl>
							<dt>22</dt>
							<dd>What does “Carpe Diem” mean to you?</dd>
						</dl>
						<textarea id="favorite-salad" 
								  placeholder="Answer goes here...">
						</textarea>
					</div>

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

					<input type="button" id="submit" value="Send" />
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