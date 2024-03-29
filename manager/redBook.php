<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ru" lang="ru" dir="ltr">
<head>
	<title>Формат обмена данными JSON</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="Content-Language" content="ru" />
	<link rel="stylesheet" type="text/css" href="json_1.css" />
	<script type="text/javascript" src="xmlhttprequest.js"></script>
	<script type="text/javascript" src="json2.js"></script>
	<script type="text/javascript">
		// Покажем список книг
		function showBooks()
		{
			// Объект запроса
			var req = getXmlHttpRequest();
			req.onreadystatechange = function()
				{
					if (req.readyState != 4) return;
					
					// Очистка предыдущих результатов
					var divResult = document.getElementById("divResult");
					while (divResult.hasChildNodes())
						divResult.removeChild(divResult.lastChild);					
					
					// Обработка JSON пакета
					//console.log(req.responseText);
					var books = eval(req.responseText);
					
					// Отображение книг
					for (var i = 0; i < books.length; i++)
						showBook(books[i]);
				}
			var txtCat = document.getElementById("txtCat");
			req.open("GET", "getBook.php?cat=" + txtCat.value, true);
			req.send(null);			
		}
		
		// Создание элемента с тектом
		function createElement(tag, text)
		{
			var element = document.createElement(tag);
			var elementText = document.createTextNode(text);
			element.appendChild(elementText);
			return element;
		}
		
		
		// Отображение книги
		function showBook(objBook)
		{
			var imagePath = "../../images/";
			var divResult = document.getElementById("divResult");
			var divBook = document.createElement("div");
			divBook.className = "book";
			divResult.appendChild(divBook);
			var divBookAuthor = createElement("h3", objBook.author);
			divBook.appendChild(divBookAuthor);
			var divBookTitle = createElement("h2", objBook.title);
			divBook.appendChild(divBookTitle);			
			var divBookImage = document.createElement("img");
			divBookImage.src = imagePath + objBook.image;
			divBook.appendChild(divBookImage);		
		}
	</script>
</head>
<body>
	<h1>Формат обмена данными JSON</h1>
	<form onsubmit="return false">
		<label for="txtCat">Код категории</label>
		<input id="txtCat" type="text" value="1" />
		<button onclick="showBooks()">Показать</button>
	</form>
	<div id="divResult"></div>
</body>
</html>

