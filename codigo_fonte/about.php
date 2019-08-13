<?php
	session_start();
	error_reporting(E_ALL);
	ini_set("display_errors", 1);

	echo "<h1 style='margin:auto; text-align:center; padding-top:10px;'> 
			- About DropMusic - 
		</h1>

		<div class='container' id='topNav'>
			<nav class='navbar navbar-expand-sm bg-light justify-content-center' id='navTop' style='text-align: justify; text-justify: inter-word;'>

				<vi style='text-align: justify; text-justify: inter-word;'>
					DropMusic is a project done for the subject of Data Bases, whose purpose is to create a management and sharing song 
					aggregation system, much like <a href='https://www.imdb.com/'>Imdb.com</a> or 
					<a href='https://www.allmusic.com/'>AllMusic.com</a>. The system should also allow users the possibility to share files
					among each other, like <a href='https://www.dropbox.com/'>Dropbox.com</a>, and it should have all relevant information
					about songs, its corresponding musicians, albums, bands, composers, lyrics, concerts and other important aspects. 
					<br><br>
					We decided to follow a web-based approach, as it would allow us not only to expand our HTML, PHP, JS and CSS knowledge, 
					but also because we believe the development of a distributed system involving an external database would be simpler to
					implement this way. Furthermore, our web-based approach allowed us to create a simple and user-friendly graphical user
					interface, which makes <a href='main.html'>DropMusic.tk</a> much easier to use.
					<br><br>
					Feel free to roam through our website. We hope you enjoy it and its many features. If any bug or error is found, or if
					you believe some additional feature could benefit the website, please go ahead and contact us using the information
					below. If you would like to become an editor, you can also send your username and request to either of our e-mail 
					addresses. Cheers!
					<br><br>
					Gustavo & Bruno
				</vi>
			</nav>
		</div>

		<div class='row' style='padding-top:40px;'>
 			<div class='column'>
				<h2 style='text-align:center;'>Gustavo Assunção</h2>

				<div class='container' id='topNav'>
					<nav class='navbar navbar-expand-sm bg-light justify-content-center' id='cTop'>
						<div style='position:absolute; top:20px; left:20px;'>
							<img src='gustavo.jpg' alt='Avatar' style='border-radius: 50%; height: 170px; width: 170px;'>
						</div>

						<vi style='position:absolute; top:20px; left:220px;'>
							<h3>Info:</h3>
							<address>
								Student #2014197707 - MIEEC<br>
								gustavomiguelsa@gmail.com<br> 
								+351 937 792 011<br>
								My <a href='https://www.linkedin.com/in/gustavo-miguel-santos-assun%C3%A7%C3%A3o-432291104/'>LinkedIn</a><br>
								<br><b><i> Webmaster & Backend developer </i></b><br>
							</address>
						</vi>

						<vi style='padding-top:200px; text-align: justify; text-justify: inter-word;'>
						<br>
						Gustavo Assunção is an M.Sc. student and AP4ISR team member, at the Institute of Systems and Robotics (ISR) 
						of the University of Coimbra. He is currently doing research on human emotion recognition through speech analysis 
						using Convolutional Neural Networks (CNNs), for his M.Sc. dissertation, under the supervision of Prof. Paulo 
						Menezes and Prof. Fernando Perdigão conjointly.</vi>
					</nav>
				</div>
			</div>

  			<div class='column'>
				<h2 style='text-align:center;'>Bruno Ferreira</h2>

				<div class='container' id='topNav'>
					<nav class='navbar navbar-expand-sm bg-light justify-content-center' id='cTop'>
						<div style='position:absolute; top:20px; left:20px;'>
							<img src='bruno.jpg' alt='Avatar' style='border-radius: 50%; height: 170px; width: 170px;'>
						</div>

						<vi style='position:absolute; top:20px; left:220px;'>
							<h3>Info:</h3>
							<address>
								Student #2014201123 - MIEEC<br>
								brunomfferreira@hotmail.com<br> 
								+351 910 917 531<br>
								My <a href='https://www.linkedin.com/in/brunomfferreira/'>LinkedIn</a><br>
								
								<br><b><i> Frontend & Backend developer </i></b><br>
							</address>
						</vi>

						<vi style='padding-top:200px; text-align: justify; text-justify: inter-word;'>
						<br>
						Bruno Ferreira is an M.Sc. student and AP4ISR team member, at the Institute of Systems and Robotics (ISR) 
						of the University of Coimbra. He is currently doing research on Serious Games for Motor Rehabilitation using 
						Virtual Reality and Immersive Technologies, for his M.Sc. dissertation, under the 
						supervision of Prof. Paulo Menezes.</vi>
					</nav>
				</div>
			</div>

		</div>";
?>
