<div class="d-flex flex-column mt-5">
    <h2 class="row justify-content-center font-weight-bold mb-4">Profile de <?= $this->session->get('username'); ?></h2>
    <div class="row justify-content-center mb-4 font-italic">
        <div class="row justify-content-center">
            <ul class="list-group list-group-flush text-lg-center text-sm-left">
                <li class="list-group-item font-italic pt-4"><span class="font-weight-bold"><u>Mon status</u> : </span>
                    <span class="text-success">Compte activé</span>
                </li>
                <li class="list-group-item font-italic pt-4"><span
                            class="font-weight-bold"><u>Mon email</u> : </span><span
                            class="text-info"><?= $this->session->get('email') ?></span></li>
            </ul>
        </div>
    </div>





