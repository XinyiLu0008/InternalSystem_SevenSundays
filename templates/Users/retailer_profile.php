<?php



$this->Breadcrumbs->add([
    [
        'title' => 'Dashboard',
        'url' => ['controller' => 'users', 'action' => 'retailerProfile'],
        'options' => ['class' => 'breadcrumb-item']
    ]]);





$this->Breadcrumbs->setTemplates([
    'wrapper' => '<ol class="breadcrumb mb-4"{{attrs}}>{{content}}</ol>',

]);

echo $this->Breadcrumbs->render();  ?>


<div class="container">
    <title>
        Retailer Profile
    </title>



    <div class="container-fluid">
        <div class="row">

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card-counter info">
                    <i class="fa fa-cash-register fa-2x"></i>
                    <span class="count-numbers"><?= $this->Html->link(__('Place Order'), ['controller' => 'Sales', 'action' => 'add'],
                            ['class' => '', 'style' => 'color: white']) ?> </span>

                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card-counter warning">
                    <i class="fas fa-box-open fa-2x"></i>
                    <span class="count-numbers"><?= $this->Html->link(__('My Orders'), ['controller' => 'Sales', 'action' => 'index'],
                            ['class' => '', 'style' => 'color: white']) ?></span>

                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card-counter success">
                    <i class="fa fa-pump-soap fa-2x"></i>
                    <span class="count-numbers"><?= $this->Html->link(__('Products'), ['controller' => 'Products', 'action' => 'index'],
                            ['class' => '', 'style' => 'color: white']) ?></span>

                </div>
            </div>


        </div>
    </div>
    <hr>


    <div class="col">
        <div class="row">
            <div class="col mb-3">
                <div class="card">
                    <div class="card-body">
                        <div class="e-profile">
                            <div class="row">
                                <div class="col-12 col-sm-auto mb-3">
                                    <div class="mx-auto" style="width: 140px;">

                                        <div class="d-flex justify-content-center align-items-center rounded" style="height: 140px; background-color: rgb(233, 236, 239);">
                                            <div class="square-box pull-left">
                                                <div class="col-auto">
                                                    <?= $this->Html->image('user2.png', ['style' => 'max-width:160px;height:140px;']); ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col d-flex flex-column flex-sm-row justify-content-between mb-3">
                                    <div class="text-center text-sm-left mb-2 mb-sm-0">
                                        <h4 class="pt-sm-2 pb-1 mb-0 text-nowrap"><?= $this->Identity->get('first_name') ?> <?= $this->Identity->get('last_name') ?></h4>

                                        <div class="profile-work">
                                            <a href="https://www.sevensundays.com.au/">https://www.sevensundays.com.au/</a><br/>
                                            <p><span class="mr-1"><i class="fa fa-map-pin" aria-hidden="true"></i> <?= $this->Identity->get('country') ?></span></p>
                                        </div>



                                        <button type="button" class="btn btn-light btn-md mr-1 mb-2">
                                           <?= $this->Html->link(__('Update Profile'), ['action' => 'edit', $this->Identity->get('id')],
                                                ['class' => 'side-nav-item']) ?></button>





                                    </div>

                                    <div class="text-center text-sm-right">
                                        <span class="badge badge-secondary">  <?= $this->Identity->get('role') ?></span>
                                        <div class="text-muted"><small>Joined <?= $this->Identity->get('created') ?></small></div>
                                        <div class="text-muted"><small>Last modified  <?= $this->Identity->get('modified') ?></small></div>
                                    </div>
                                </div>
                            </div>
                            <ul class="nav nav-tabs">

                            </ul>

                            <div class="tab-content pt-3">

                                <div class="row">
                                    <div class="col-md-6">
                                        <h6 class="card-title font-weight-bold">First Name</h6>
                                    </div>
                                    <div class="col-md-6">
                                        <p><?= $this->Identity->get('first_name') ?></p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <h6 class="card-title font-weight-bold">Last Name</h6>
                                    </div>
                                    <div class="col-md-6">
                                        <p><?= $this->Identity->get('last_name') ?></p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <h6 class="card-title font-weight-bold">Email</h6>
                                    </div>
                                    <div class="col-md-6">
                                        <p><?= $this->Identity->get('email') ?></p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <h6 class="card-title font-weight-bold">Phone</h6>
                                    </div>
                                    <div class="col-md-6">
                                        <p><?= $this->Identity->get('phone') ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-3 mb-3">

                <div class="card">
                    <div class="card-body">
                        <h6 class="card-title font-weight-bold">Contact Info</h6>
                        <p class="card-text">
                             Email:
                            <a href="mailto:contact@sevensundays.com.au">contact@sevensundays.com.au</a><br>
                            Phone: 0421 323 986
                           </p>

                    </div>
                </div>
            </div>
        </div>
        <br>
        <br>
    </div>


    </div>
</div>


</div>

<script>
    // sandbox disable popups
    if (window.self !== window.top && window.name != "view1") {
        window.alert = function () {
            /*disable alert*/
        };
        window.confirm = function () {
            /*disable confirm*/
        };
        window.prompt = function () {
            /*disable prompt*/
        };
        window.open = function () {
            /*disable open*/
        };
    }
    // prevent href=# click jump
    document.addEventListener(
        "DOMContentLoaded",
        function () {
            var links = document.getElementsByTagName("A");
            for (var i = 0; i < links.length; i++) {
                if (links[i].href.indexOf("#") != -1) {
                    links[i].addEventListener("click", function (e) {
                        console.debug("prevent href=# click");
                        if (this.hash) {
                            if (this.hash == "#") {
                                e.preventDefault();
                                return false;
                            } else {
                                /*
                                    var el = document.getElementById(this.hash.replace(/#/, ""));
                                    if (el) {
                                      el.scrollIntoView(true);
                                    }
                                    */
                            }
                        }
                        return false;
                    });
                }
            }
        },
        false
    );
</script>
<!--scripts loaded here-->
<script src="//ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/tether/1.2.0/js/tether.min.js"></script>
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js"></script>
<script>
    $(document).ready(function () {
        $("[data-toggle=offcanvas]").click(function () {
            $(".row-offcanvas").toggleClass("active");
        });
    });
</script>


</body>
</html>
