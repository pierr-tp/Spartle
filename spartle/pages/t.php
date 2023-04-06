		function getMessages() {
			const reqAjax = new XMLHttpRequest();
			reqAjax.open("GET", "handler.php");
			reqAjax.onload = function() {
				const result = JSON.parse(reqAjax.responseText);
				const html = result.reverse().map(function(publication) {
					return '<article>'
		'<div class="publis">'
			'<div class="p-pseudo">'
			{publication.pseudo}
			'</div>'
			'<div class="p-datepost">'
			{publication.date_post.substring(11, 16)}
			'</div>'
			'<hr class="line">'
			'<div class="p-content">'
			{publication.publication}
			'</div>'
			'<button class="like" title="Liker"><i class="far fa-heart"></i></button>'
			'<button class="comment" title="Commenter"><i class="far fa-comment"></i></button>'
			'<button class="share" title="Partager"><i class="fas fa-share-square"></i></button>'
			'<button class="more" title="Plus"><i class="fas fa-plus"></i></button>'
		'</div>'
		'</article>';
				}).join("");
				const publications = document.querySelector(".publis");
				publications.innerHTML = html;
				publications.scrollTop = publications.scrollHeight;
			}
			reqAjax.send();
		}
		function postMessage(e) {
			e.preventDefault();
			const pseudo = "<?php echo $_SESSION["pseudo"];?>";
			const publication = document.querySelector("#publication_area_write");
			const data = new FormData();
			data.append('pseudo', pseudo.value);
			data.append('publication', publication.value);
			const reqAjax = new XMLHttpRequest();
			reqAjax.open("POST", "handler.php?task=write");
			reqAjax.onload = function(){
				getMessages();
			}
			reqAjax.send(data);
		}
		document.querySelector("form").addEventListener("submit", postMessage());