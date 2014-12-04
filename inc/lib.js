/*
    Функция возвращат объект XMLHttpRequest
*/
function getXmlHttpRequest()
{
	if (window.XMLHttpRequest) 
	{
		try 
		{
			return new XMLHttpRequest();
		} 
		catch (e){}
	} 
	else if (window.ActiveXObject) 
	{
		try 
		{
			return new ActiveXObject('Msxml2.XMLHTTP');
		} catch (e){}
		try 
		{
			return new ActiveXObject('Microsoft.XMLHTTP');
		} 
		catch (e){}
	}
	return null;
}


/*
    Функция проверяет заполнены ли все поля формы
*/
function checkForm(){
    
}


/*
    функция отправляет POST запрос на сервер на вход пользователя в систему
*/
function checkLog(){
    var name = document.getElementById("txtUser").value;
    var password = document.getElementById("txtString").value;
    var request = "login=" + name + "&" + "password=" + password;
//    alert(request);
    var req = getXmlHttpRequest();
    req.onreadystatechange = function(){
        if (req.readyState == 4){
            var answer = req.responseText;
            if (!answer)
                alert("Вы ввели неверный логин или пароль");
            else
                location.replace(answer);
        }
    };
    req.open("POST", "inc/secure/login.php", true);
    req.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    req.setRequestHeader("Content-Length", request.length);
    req.send(request);
}


/*
    функция отправляет POST запрос на сервер на выход пользователя из системы
*/
function logOut(){
    var req = getXmlHttpRequest();
    var query = "logout=exit";
    req.onreadystatechange = function(){
        if (req.readyState == 4){
            var answer = req.responseText;
            location.replace(answer);
        }
    };
    req.open("POST", "inc/secure/logout.php", true);
    req.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    req.setRequestHeader("Content-Length", query.length);
    req.send(query);
}


/*
    функция добавляет года в select на странице админа в форме для добавления новых книг в базу
*/
function addYear(flag){
    if (flag){
	   var s = document.forms[0].year;
       var o = s.options;
       var year = parseInt(o[o.length - 1].value) + 1;
       var newOpt = new Option(year, year, false, true);
       s.add(newOpt, null);
    } else{
	   var s = document.forms[0].year;
       var o = s.options;
       var year = parseInt(o[0].value) - 1;
       var newOpt = new Option(year, year, false, true);
       s.add(newOpt, 0);
    }
}

/*
    функция отправляет GET запрос на сервер для добавления книги в корзину.
    Если у пользователя нету соответствующих прав - будет выдано соответствующее сообщение.
*/
function addToBasket(id){
    req = new XMLHttpRequest;
    req.onreadystatechange = function(){
        if (req.readyState == 4){
            var res = req.responseText;
            if (res)
                alert(res);
        }
        };
    req.open("GET", "inc/add2Basket.php?id=" + id, true);
    req.send(null);
}


/*
    функция отправляет GET запрос на удаление книги из базы.
*/

function deleteBook(id){
    alert("Вы дейсьвительно хотите удалить выбранную книгу");
    req = new XMLHttpRequest;
    req.onreadystatechange = function(){
        if (req.readyState == 4){
            var res = req.responseText;
            if (res)
                alert(res);
            else
                location.reload(true);
        }
        };
    req.open("GET", "inc/deleteBook.php?id=" + id, true);
    req.send(null);
}

/*
    функция отправляет GET запрос на редактирование книги из базы.
*/

function redactBook(id){
//    alert("Вы дейсьвительно хотите редактировать выбранную книгу");
    req = new XMLHttpRequest;
    req.onreadystatechange = function(){
        if (req.readyState == 4){
            var divResult = document.getElementById("divResult");
            while (divResult.hasChildNodes())
                divResult.removeChild(divResult.lastChild);
            
            var res = req.responseText;
			var book = eval("(" + res + ")");
            console.log(book);
            drawRedactForm(book);		
            alert("Эта опция еще в процессе разработки!!!");
            }            
        };
    req.open("GET", "inc/getBook.php?id=" + id, true);
    req.send(null);
}


/*
    функция которая отображает форму для редактирования данных книги
*/
		function drawRedactForm(objBook = ""){
            
            //создаем элемент <form> со всеми нужными параметрами
            var divResult = document.getElementById("divResult");
            var bookForm = document.createElement("div");
            bookForm.action = "javascript:";
            bookForm.enctype = "multipart/form-data";
            bookForm.method = "post";
            divResult.appendChild(bookForm);
            
            //поле для редактирования автора книги
            var inputBookAuthor = createLabelAndInputElements("Автор", "input", "text", name="author", objBook.author);
            bookForm.appendChild(inputBookAuthor);
            
            //поле для редактирования названия книги
            var inputBookTitle = createLabelAndInputElements("Название", "input", "text", name="title", objBook.title);
            bookForm.appendChild(inputBookTitle);
            
            //поле для редактирования цены книги
            var inputBookPrice = createLabelAndInputElements("Цена", "input", "text", name="price", objBook.price);
            bookForm.appendChild(inputBookPrice);
            
            //поле для редактирования фотографии книги
            var inputBookImage = createLabelAndInputElements("Изображение", "input", "file", name="load");
            bookForm.appendChild(inputBookImage);
            var image = document.createElement("img");
            image.src = objBook.image;
            inputBookImage.appendChild(image);
            
            //поле для редактирования описания книги
            var inputBookDesc = createLabelAndInputElements("Описание товара", "textarea", "text", name="description", objBook.description);
            bookForm.appendChild(inputBookDesc);
            
            var inputButton = document.createElement("input");
            inputButton.type = "button";
            inputButton.value = "Редактировать книгу";
            bookForm.appendChild(inputButton);
            
		}






        // Create input and label for this input
		function createLabelAndInputElements(labelText, tag="", type="", name="", text="")
		{
            //создаем блок
            var block = document.createElement("p");
            //создаем елемент <label> с текстом
            var label = document.createElement("label");
            block.appendChild(label);
            label.htmlFor = name;
            var elementText = document.createTextNode(labelText);
            label.appendChild(elementText);
            
            
            //создаем елемент <input> с необходимыми параметрами
            var input = document.createElement(tag);
            input.type = type;
            input.name = name;
            input.id = name;
            input.value = text;
            block.appendChild(input);
            
            return block;
		}
		

function findBook(){
    alert("Еще не дописал");
}







