<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Add New User</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
</head>
<body>
    <div>
        <span>Ім'я</span>
        <input type="text" name="name" id="name">
    </div>
    <div>
        <span>Email</span>
        <input type="text" name="email" id="email">
    </div>
    <div>
        <span>Photo</span>
        <input type="file" name="photo" id="photo">
    </div>
    <button onclick="AddUser()">Додати</button>

    <div>
        <table>
        </table>
        <button onclick="NextSix()""> Наступні 6</button>
    </div>
    
    <script>
        
        $('document').ready(async function(){
            const url = 'http://127.0.0.1:8000/api/users/1-6';
            try{
                const response = await fetch(url,{
                    method: 'GET'
                })
                const result = await response.json();
                result.forEach(function(element){
                    let id = element.id;
                    let name = element.name;
                    let email = element.email;
                    var markup = "<tr><td id='id'>" + id + "</td><td>" + name + "</td><td>" + email + "</td></tr>";
                    $("table").append(markup)
                });
                
                
            }catch (error) {
                console.error('Ошибка:', error);
            }
        })

        async function NextSix(){
            const url = 'http://127.0.0.1:8000/api/users/';
            let firstId = parseInt($("table tr:last td:first").html()) +1;
            let lastId = firstId + 6;
            try{
                const response = await fetch(url+firstId+'-'+lastId,{
                    method: "GET"
                })
                const result = await response.json();
                $('table tr').each(function(index, tr){
                    $(tr).remove();
                });
                result.forEach(function(element){
                    let id = element.id;
                    let name = element.name;
                    let email = element.email;
                    var markup = "<tr><td id='id'>" + id + "</td><td>" + name + "</td><td>" + email + "</td></tr>";
                    $("table").append(markup)
                });

            }catch (error){
                console.error('Ошибка:', error);
            }
            
        }

        async function AddUser(){
            const url = 'http://127.0.0.1:8000/api/users';
            const formData = new FormData();

            const fileField = document.querySelector('input[type="file"]');
            let name = document.getElementById('name').value;
            let email = document.getElementById('email').value;

            formData.append('name', name);
            formData.append('email', email);
            formData.append('photo', fileField.files[0]);
            try{
                const response = await fetch(url, {
                    method: 'POST',
                    body: formData,
                });
                const result = await response.json();
                console.log('Успех:', JSON.stringify(result));
            }catch (error) {
                console.error('Ошибка:', error);
            }
        }
    </script>
</body>
</html>