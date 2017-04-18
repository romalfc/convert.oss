<html lang="en"><head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Sender API</title>

    <!-- Bootstrap core CSS -->
    <?=Asset::css('bootstrap.min.css')?>

    <!-- Custom styles for this template -->
    <?=Asset::css('send_form.css')?>

  </head>

  <body>
    <div class="container">
        <form id="converter" onsubmit="sendForm();" action="/convert" class="form-signin" method="POST" enctype="multipart/form-data">
            <h2 class="form-signin-heading">Convert.OSS</h2>
            <p id="e_box" style=""></p>
            <label for="input">Select input file
                <input type="file" name="input" class="form-control" placeholder="File" required="" value=" ">
            </label>
            <label for="output">Output format
                <select name="output" class="form-control">
                    <option value="csv">CSV</option>
                    <option value="xml">XML</option>
                    <option value="yml">YAML</option>
                    <option value="json">JSON</option>
                </select>          
            </label>
            <br><br>
            <button type="submit" name="submit" style="" class="btn btn-lg btn-primary btn-block">Convert</button>  
            <img id="loading" src="/assets/img/arrows.gif" class="img-responsive">
            <button id="d_button" onclick="downloadFile();" type="button" class="btn btn-lg btn-primary btn-block">Download</button>
        </form>
    </div>
    <script>
        function sendForm() {
            var data = {
                input: document.forms.converter.input.files[0],
                output: document.forms.converter.output.value
            };
            var action = document.forms.converter.action;

            var formData = new FormData();
            formData.append("input", data.input);
            formData.append("output", data.output);
            var s_button = document.forms.converter.submit;
            var d_button = document.getElementById('d_button');
            var img = document.getElementById('loading');
            var e_box = document.getElementById('e_box');

            s_button.style.display = 'none';
            img.style.display = 'block';
            e_box.style.display = 'none';


            var xhr = new XMLHttpRequest();
            xhr.open('POST', action, true);

            xhr.onreadystatechange = function() {                            
                if (this.readyState != 4) return;
                img.style.display = 'none';                 
                if (xhr.status != 200) {
                    if (xhr.status == 500) {
                        setError(e_box, 'Too big file for convertation!', s_button);
                    } else setError(e_box, 'Unknown error!', s_button);                    
                    return;
                }    
                var response = JSON.parse(this.responseText);
                if(typeof response.errors != 'undefined'){                
                    setError(e_box, response.errors, s_button);                
                }
                if(typeof response.success != 'undefined'){                
                    d_button.setAttribute('data-src', response.success);                
                    d_button.style.display = 'inline-block';
                }
            }

            xhr.send(formData);
            event.preventDefault();
        }

        function setError(e_box, errorText, s_button){
            e_box.textContent = errorText;
            e_box.style.display = 'inline';            
            s_button.style.display = 'inline-block';
        }

        function downloadFile(){
            var s_button = document.forms.converter.submit;
            var d_button = document.getElementById('d_button');
            var src = d_button.getAttribute('data-src');
            window.location.href = src;
            d_button.style.display = 'none';
            s_button.style.display = 'inline-block';
        }
    </script>
</body>
</html>