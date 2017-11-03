<?php
$resAct[0]=2;
if($_GET['actCode']!='' && $_GET['id']!=''){
    $resAct = $user->checkActivationCode($_GET['actCode'],$_GET['id']);
}
if(isset($_POST['signup'])){
    $resAct = $user->validationRegister($_POST['name'],$_POST['email'],$_POST['password']);
}
?>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-5">
            <section class="form-light mt-10">
                <?php echo $user->resMethod($resAct[0],$resAct[1]);?>
                <form action="index.php" method="post"  name="register" >
                    <!--Form without header-->
                    <div class="card">
                        <div class="card-body mx-4">
                            <div class="text-center">
                                <h3 class="pink-text mb-5"><strong>Sign up</strong></h3>
                            </div>
                            <div class="md-form">
                                <input type="text" id="Form-email2" class="form-control" name="email" ng-model="email" required>
                                <label for="Form-email2">Your email</label>
                                <span  style="color:red" ng-show="register.email.$error.required">Email is required.</span>
                                <span style="color:red" ng-show="register.email.$error.email">Invalid email address.</span>
                            </div>
                            <div class="md-form">
                                <input type="text" id="Form-name" class="form-control" name="name" ng-model="name" required>
                                <label for="Form-pass2">Your name</label>
                                <span style="color:red" ng-show="register.name.$error.required">Name is required.</span>
                            </div>
                            <div class="md-form pb-3">
                                <input type="password" id="Form-pass2" class="form-control" name="password" ng-model="password" required>
                                <label for="Form-pass2">Your password</label>
                                <span style="color:red" ng-show="register.password.$error.required">Password is required.</span>
                            </div>
                            <div class="row d-flex align-items-center mb-4">
                                <div class="col-md-3 col-md-6 text-center">
                                    <button type="submit"  class="btn btn-pink btn-block btn-rounded z-depth-1" name="signup">Sign up</button>
                                </div>
                                <div class="col-md-6">
                                    <p class="font-small grey-text d-flex justify-content-end">Have an account? <a href="http://localhost/test-project/login.php" class="blue-text ml-1"> Log in</a></p>
                                </div>
                            </div>
                        </div>
                        <div class="footer pt-3 mdb-color lighten-3 h100">
                            <div class="row d-flex justify-content-center">
                            </div>
                            <div class="row mt-2 mb-3 d-flex justify-content-center">
                            </div>
                        </div>
                    </div>
                    <!--/Form without header-->
                </form>
            </section>
        </div>

    </div>
</div>
