<!--== #HEADER ==-->
<?php adminHeader($data); ?>
<div class="app-form">
    <form class="form-data " data-destination="auth" calling-method="setLogin" data-type="json">

        <div class="form-header">
            <div class="title">
                <h3>Login</h3>
            </div>
            <div class="description">
                <p>Ingrese sus credenciales</p>
            </div>
        </div>
        <div class="form-body">
            <div class="form-grid column-1">
                <div class="form-box label">
                    <label class="label-input" for="userEmail">Identidad</label>
                    <input class="control-box small" type="text" name="userEmail" id="userEmail" placeholder="Correo">
                </div>
                <div class="form-box label">
                   <label class="label-input" for="userPassword">Contraseña</label>
                   <input class="control-box small" type="text" name="userPassword" id="userPassword" placeholder="Contraseña">
                </div>
            </div>
        </div>
        <div class="form-footer">
            <div class="buttons">
                <button id="send-login" class="button button-primary big-button">Acceder</button>
            </div>
        </div>
    </form>
</div>
<!--== #FOOTER ==-->
<?php adminFooter($data); ?>