<?php include ("header.php");
$resAct[0]=2;
if(isset($_POST['login'])){
    $resAct = $user->validationLogin($_POST['email'],$_POST['password']);
}
?>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-5">
            <?php echo $user->resMethod($resAct[0],$resAct[1]);?>
            <form action="login.php" method="post"  name="login" >
                <section class="form-simple mt-10">
                    <div class="card">
                        <div class="header pt-3 grey lighten-2">
                            <div class="row d-flex justify-content-start">
                                <h3 class="deep-grey-text mt-3 mb-4 pb-1 mx-5">Log in</h3>
                            </div>
                        </div>
                        <div class="card-body mx-4 mt-4">
                            <div class="md-form">
                                <input type="text" id="Form-email4" class="form-control" name="email">
                                <label for="Form-email4">Your email</label>
                            </div>

                            <div class="md-form pb-3">
                                <input type="password" id="Form-pass4" class="form-control" name="password">
                                <label for="Form-pass4">Your password</label>
                                <p class="font-small grey-text d-flex justify-content-end">Forgot <a href="#" class="dark-grey-text font-bold ml-1"> Password?</a></p>
                            </div>

                            <div class="text-center mb-4">
                                <button type="submit" class="btn btn-danger btn-block z-depth-2" name="login">Log in</button>
                            </div>
                            <p class="font-small grey-text d-flex justify-content-center">Don't have an account? <a href="http://localhost/test-project/index.php" class="dark-grey-text font-bold ml-1"> Sign up</a></p>
                        </div>
                    </div>

                </section>
            </form>
        </div>
    </div>
</div>
<?php include ("footer.php");?>