<!DOCTYPE html>
<html lang="en" class="has-background-white-bis has-text-black-bis">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <title>FaultCat</title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.7.5/css/bulma.min.css" integrity="sha256-vK3UTo/8wHbaUn+dTQD0X6dzidqc5l7gczvH+Bnowwk=" crossorigin="anonymous" />
        <style>
            body {text-align : center;}
            .is-horizontal-center {justify-content: center;}
            .hide {display: none;}
            .show {display: block;}
            .underline {text-decoration: underline;}
            .options {margin-top: 15px;}
            .problem {border: 5px solid #FFDD57; }
            .btn-info {padding-top: 25px;}
            .hero-head .container {padding: 5px 0 5px 0;}
            .hero-head {margin-bottom: 1%;}
            .tag {margin-bottom: 2px;}
            #Y, #N, #fetch, #change {margin-bottom: 2px;}
            .btn-translate {padding: 10px 0;}
            /*.column {border:1px solid black;}*/
        </style>
    </head>
    <body>
        <div class="modal" id="modal-info">
            <div class="modal-background"></div>
            <div class="modal-card">
                <header class="modal-card-head has-background-warning">
                    <p class="modal-card-title">About FaultCat</p>
                    <button id="btn-info-close" class="delete" aria-label="close"></button>
                </header>
                <section class="modal-card-body">
                    <div class="container  notification">
                        <p class="is-size-6 is-size-7-mobile is-size-7-tablet">“We had a kettle; we let it leak:<br>
                            Our not repairing made it worse.<br>
                            We haven't had any tea for a week...<br>
                            The bottom is out of the Universe.”<br>
                            ― Rudyard Kipling
                        </p>
                    </div>
                    <div class="container content">
                        <p>We'd like to group repairs into streams that can be reported and visualised. We don't need to pinpoint the exact cause of each fault.</p>
                        <p>Read more about
                            <a href="https://therestartproject.org/fixometer/why-we-collect-repair-data/" target="_blank">why we collect data</a>
                            and
                            <a href="https://openrepair.org/data-dives/open-repair-data-fixfest-2019-why-computers-fail/" target="_blank">why computers fail</a>
                        </p>
                        <p>A variety of languages are present in the database, if your browser does not prompt to translate you can use the <a href="https://translate.google.com/" target="_blank">Google Translate button</a></p>
                        <!-- https://translate.google.com/intl/en/about/website/
                        We no longer provide new access to Google Translate's Website Translator. This change does not affect existing use of the Website Translator.
                        We encourage users looking to translate webpages to use browsers that support translation natively.
                        -->
                        <p><a href="https://talk.restarters.net/t/faultcat-repair-data-for-the-many-not-the-few-feedback-please/2213" target="_blank">Tell us what you think of this app</a></p>
                        <p>** Version 3.0-beta **</p>
                    </div>
                </section>
                <footer class="modal-card-foot has-background-warning has-text-weight-bold">
                    <div class="container">
                        <p><a href="https://therestartproject.org/" target="_blank">The Restart Project</a></p>
                        <p>A member of the <a href="https://openrepair.org/" target="_blank">Open Repair Alliance</a></p>
                    </div>
                </footer>
            </div>
        </div>
        <div class="hero is-centered">
            <div class="hero-head has-background-warning">
                <div class="container content">
                    <div class="columns is-flex-mobile is-flex-tablet">
                        <div class="column is-1 btn-info">
                            <button id="btn-info-open" class="button is-primary">
                                <svg style="width:24px;height:24px" viewBox="0 0 24 24">
                                <title>About FaultCat</title>
                                <path fill="#000000" d="M13.5,4A1.5,1.5 0 0,0 12,5.5A1.5,1.5 0 0,0 13.5,7A1.5,1.5 0 0,0 15,5.5A1.5,1.5 0 0,0 13.5,4M13.14,8.77C11.95,8.87 8.7,11.46 8.7,11.46C8.5,11.61 8.56,11.6 8.72,11.88C8.88,12.15 8.86,12.17 9.05,12.04C9.25,11.91 9.58,11.7 10.13,11.36C12.25,10 10.47,13.14 9.56,18.43C9.2,21.05 11.56,19.7 12.17,19.3C12.77,18.91 14.38,17.8 14.54,17.69C14.76,17.54 14.6,17.42 14.43,17.17C14.31,17 14.19,17.12 14.19,17.12C13.54,17.55 12.35,18.45 12.19,17.88C12,17.31 13.22,13.4 13.89,10.71C14,10.07 14.3,8.67 13.14,8.77Z" />
                                </svg>
                            </button>
                        </div>
                        <div class="column is-9">
                            <a class="subtitle has-text-grey-dark has-text-weight-bold" href="https://therestartproject.org/" target="_blank"><span class="is-size-7-mobile">The Restart Project</span></a>
                            <br><span class="title is-size-5-mobile">FaultCat</span>
                        </div>                        
                        <div class="column is-1 cat-icon">
                            <!--
                            These images are licensed under the Creative Commons Attribution 4.0 International license.
                            Attribution: Vincent Le Moign
                            https://commons.wikimedia.org/wiki/Category:SVG_emoji_smilies
                            -->                            
                            <?php
                            if ($fault) {
                                switch ($fault->repair_status) {
                                    case 'Fixed': $img = '099-smiling-cat-face-with-heart-eyes-64px.svg.png';
                                        $alt = 'LoveCat';
                                        break;
                                    case 'Repairable': $img = '097-grinning-cat-face-with-smiling-eyes-64px.svg.png';
                                        $alt = 'HappyCat';
                                        break;
                                    case 'End of life': $img = '103-crying-cat-face-64px.svg.png';
                                        $alt = 'SadCat';
                                        break;
                                    case 'Unknown': $img = '102-weary-cat-face-64px.svg.png';
                                        $alt = 'HuhCat';
                                        break;
                                }
                            } else {
                                $img = '100-cat-face-with-wry-smile.svg.png';
                                $alt = 'MehCat';
                            }
                            ?>
                            <img src="{{ asset('/images/faultcat/'.$img) }}" alt="{{ $alt }}"/>
                        </div>
                        <div class="column is-1 btn-info">
                            <div id="user" class="dropdown">
                                <div class="dropdown-trigger">
                                    <button class="button  is-primary" aria-haspopup="true" aria-controls="dropdown-menu">
                                        <span class=""><?php echo $user->name; ?></span>
                                        <svg style="width:24px;height:24px" viewBox="0 0 24 24">
                                        <path fill="#000000" d="M7,10L12,15L17,10H7Z" />
                                        </svg>
                                    </button>
                                </div>
                                <div class="dropdown-menu" id="dropdown-menu" role="menu">
                                    <div class="dropdown-content">
                                        <?php
                                        if ($user->id) {
                                            ?>
                                            <a href="/user/profile/<?php echo $user->id; ?>" class="dropdown-item">
                                                My Profile
                                            </a>
                                            <a href="/logout" class="dropdown-item">
                                                Logout
                                            </a>
                                            <hr class="dropdown-divider">                                        
                                            <?php
                                        } else {
                                            ?>
                                            <a href="/login" class="dropdown-item">
                                                Sign in/Register
                                            </a>
                                            <?php
                                        }
                                        ?>                                        
                                        <a href="https://talk.restarters.net/" class="dropdown-item">
                                            Forums
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="hero-foot">
                <?php if ($fault) { ?>
                    <div class="container content problem notification">
                        <div class="columns is-flex-mobile is-flex-tablet">
                            <div class="column is-12">
                                <p>
                                    <span class="tag is-large has-background-grey-lighter is-size-7-mobile is-size-6-tablet"><?php echo $fault->category; ?></span>
                                    <?php
                                    if (!empty($fault->brand) && $fault->brand !== 'Unknown') {
                                        ?>
                                        <span class="tag is-large has-background-grey-lighter is-size-7-mobile is-size-6-tablet"><?php echo $fault->brand; ?></span>
                                        <?php
                                    }
                                    if (!empty($fault->model) && $fault->model !== 'Unknown') {
                                        ?>
                                        <span class="tag is-large has-background-grey-lighter is-size-7-mobile is-size-6-tablet"><?php echo $fault->model; ?></span>
                                        <?php
                                    }
                                    if ($fault->repair_status !== 'Unknown') {
                                        ?>
                                        <span class="tag is-large has-background-grey-lighter is-size-7-mobile is-size-6-tablet"><?php echo $fault->repair_status; ?></span>
                                        <?php
                                    }
                                    ?>
                                </p>
                            </div>
                        </div>
                        <div class="columns is-flex-mobile is-flex-tablet">
                            <div class="column is-10 is-offset-1">
                                <p class="subtitle is-size-6-mobile is-size-6-tablet">
                                    <span><?php echo $fault->problem; ?></span>
                                </p>
                            </div>
                            <div class="column is-1 btn-translate is-narrow-mobile">
                                <button id="btn-translate" class="button is-size-7 is-size-7-mobile has-background-grey-dark has-text-white">
                                    <a href="https://translate.google.com/#view=home&op=translate&sl=auto&tl=en&text=<?php echo $fault->translate; ?>" target="_blank">
                                        Translate
                                    </a>
                                </button>
                            </div>
                        </div>
                    </div>
                    <form id="log-task" action="foo" method="POST">
                        @csrf
                        <div class="container fault-type">
                            <div class="container">
                                <input type="hidden" id="iddevices" name="iddevices" value="<?php echo $fault->iddevices; ?>">
                                <input type="hidden" id="fault_type" name="fault_type" value="<?php echo $fault->fault_type; ?>">
                                <p class="title is-size-6-mobile is-size-6-tablet">Is the fault type <span id="fault-type-cur" class="tag is-large has-background-grey-lighter is-size-6-mobile is-size-6-tablet"><?php echo $fault->fault_type; ?></span> ?</p>
                                <p class="buttons is-centered">
                                    <button class="button is-rounded is-success is-size-6-mobile is-size-6-tablet" id="Y">
                                        <span class="underline">Y</span>es/probably/possibly
                                    </button>
                                    <button type="submit" name="fetch" id="fetch" class="button is-rounded is-warning is-size-6-mobile is-size-6-tablet">
                                        <span class="">I don't know,&nbsp;<span class="underline">F</span>etch another one</span>
                                    </button>
                                    <button type="submit" name="fetch" id="N" class="button is-rounded is-danger is-size-6-mobile is-size-6-tablet">
                                        <span class=""><span class="underline">N</span>ope, let me pick something else</span>
                                    </button>
                                </p>
                            </div>
                            <div class="container options hide">
                                <p class="confirm hide">
                                    <button class="button is-rounded is-primary is-size-6-mobile is-size-6-tablet" id="change"><span class="underline">G</span>o with "<span id="fault-type-new"></span>"</button>
                                </p>
                                <div class="buttons is-centered">
                                    <button class="button is-size-6 is-size-7-mobile is-size-7-tablet has-text-white-bis is-rounded <?php echo ($fault->fault_type == 'Boot' ? 'has-background-grey-light' : 'has-background-grey-dark'); ?>">Boot</button>
                                    <button class="button is-size-6 is-size-7-mobile is-size-7-tablet has-text-white-bis is-rounded <?php echo ($fault->fault_type == 'Case/chassis' ? 'has-background-grey-light' : 'has-background-grey-dark'); ?>">Case/chassis</button>
                                    <button class="button is-size-6 is-size-7-mobile is-size-7-tablet has-text-white-bis is-rounded <?php echo ($fault->fault_type == 'Configuration' ? 'has-background-grey-light' : 'has-background-grey-dark'); ?>">Configuration</button>
                                    <button class="button is-size-6 is-size-7-mobile is-size-7-tablet has-text-white-bis is-rounded <?php echo ($fault->fault_type == 'Integrated keyboard' ? 'has-background-grey-light' : 'has-background-grey-dark'); ?>">Integrated keyboard</button>
                                    <button class="button is-size-6 is-size-7-mobile is-size-7-tablet has-text-white-bis is-rounded <?php echo ($fault->fault_type == 'Integrated media component' ? 'has-background-grey-light' : 'has-background-grey-dark'); ?>">Integrated media component</button>
                                    <button class="button is-size-6 is-size-7-mobile is-size-7-tablet has-text-white-bis is-rounded <?php echo ($fault->fault_type == 'Integrated optical drive' ? 'has-background-grey-light' : 'has-background-grey-dark'); ?>">Integrated optical drive</button>
                                    <button class="button is-size-6 is-size-7-mobile is-size-7-tablet has-text-white-bis is-rounded <?php echo ($fault->fault_type == 'Integrated pointing device' ? 'has-background-grey-light' : 'has-background-grey-dark'); ?>">Integrated pointing device</button>
                                    <button class="button is-size-6 is-size-7-mobile is-size-7-tablet has-text-white-bis is-rounded <?php echo ($fault->fault_type == 'Integrated screen' ? 'has-background-grey-light' : 'has-background-grey-dark'); ?>">Integrated screen</button>
                                    <button class="button is-size-6 is-size-7-mobile is-size-7-tablet has-text-white-bis is-rounded <?php echo ($fault->fault_type == 'Internal damage' ? 'has-background-grey-light' : 'has-background-grey-dark'); ?>">Internal damage</button>
                                    <button class="button is-size-6 is-size-7-mobile is-size-7-tablet has-text-white-bis is-rounded <?php echo ($fault->fault_type == 'Internal storage' ? 'has-background-grey-light' : 'has-background-grey-dark'); ?>">Internal storage</button>
                                    <button class="button is-size-6 is-size-7-mobile is-size-7-tablet has-text-white-bis is-rounded <?php echo ($fault->fault_type == 'Multiple' ? 'has-background-grey-light' : 'has-background-grey-dark'); ?>">Multiple</button>
                                    <button class="button is-size-6 is-size-7-mobile is-size-7-tablet has-text-white-bis is-rounded <?php echo ($fault->fault_type == 'Operating system' ? 'has-background-grey-light' : 'has-background-grey-dark'); ?>">Operating system</button>
                                    <button class="button is-size-6 is-size-7-mobile is-size-7-tablet has-text-white-bis is-rounded <?php echo ($fault->fault_type == 'Other' ? 'has-background-grey-light' : 'has-background-grey-dark'); ?>">Other</button>
                                    <button class="button is-size-6 is-size-7-mobile is-size-7-tablet has-text-white-bis is-rounded <?php echo ($fault->fault_type == 'Overheating' ? 'has-background-grey-light' : 'has-background-grey-dark'); ?>">Overheating</button>
                                    <button class="button is-size-6 is-size-7-mobile is-size-7-tablet has-text-white-bis is-rounded <?php echo ($fault->fault_type == 'Performance' ? 'has-background-grey-light' : 'has-background-grey-dark'); ?>">Performance</button>
                                    <button class="button is-size-6 is-size-7-mobile is-size-7-tablet has-text-white-bis is-rounded <?php echo ($fault->fault_type == 'Ports/slots/connectors' ? 'has-background-grey-light' : 'has-background-grey-dark'); ?>">Ports/slots/connectors</button>
                                    <button class="button is-size-6 is-size-7-mobile is-size-7-tablet has-text-white-bis is-rounded <?php echo ($fault->fault_type == 'Power/battery' ? 'has-background-grey-light' : 'has-background-grey-dark'); ?>">Power/battery</button>
                                    <button class="button is-size-6 is-size-7-mobile is-size-7-tablet has-text-white-bis is-rounded <?php echo ($fault->fault_type == 'System board' ? 'has-background-grey-light' : 'has-background-grey-dark'); ?>">System board</button>
                                    <button class="button is-size-6 is-size-7-mobile is-size-7-tablet has-text-white-bis is-rounded <?php echo ($fault->fault_type == 'Unknown' ? 'has-background-grey-light' : 'has-background-grey-dark'); ?>">Unknown</button>
                                    <button class="button is-size-6 is-size-7-mobile is-size-7-tablet has-text-white-bis is-rounded <?php echo ($fault->fault_type == 'Virus/malware' ? 'has-background-grey-light' : 'has-background-grey-dark'); ?>">Virus/malware</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            <?php } ?>
        </div>

        <script>
            document.addEventListener(`DOMContentLoaded`, async () => {

                document.getElementById('Y').addEventListener('click', function (e) {
                    e.preventDefault();
                    doYes();
                }, false);

                document.getElementById('N').addEventListener('click', function (e) {
                    e.preventDefault();
                    doNo();
                }, false);

                document.getElementById('change').addEventListener('click', function (e) {
                    e.preventDefault();
                    doChange();
                }, false);

                [...document.querySelectorAll('.fault-type .buttons .has-background-grey-dark')].forEach(elem => {
                    elem.addEventListener('click', function (e) {
                        e.preventDefault();
                        doOption(e);
                    });
                });

                document.querySelector('.fault-type .buttons .has-background-grey-light').disabled = true;

                document.querySelector('.dropdown-trigger').addEventListener('click', function (e) {
                    e.preventDefault();
                    document.getElementById('user').classList.add('is-active');
                });

                document.getElementById('user').addEventListener('mouseleave', e => {
                    document.getElementById('user').classList.remove('is-active');
                });

                document.getElementById('btn-info-open').addEventListener('click', function (e) {
                    e.preventDefault();
                    document.getElementById('modal-info').classList.add('is-active');
                }, false);

                document.getElementById('btn-info-close').addEventListener('click', function (e) {
                    e.preventDefault();
                    document.getElementById('modal-info').classList.remove('is-active');
                }, false);

                document.addEventListener("keypress", function (e) {
                    if (e.code == 'KeyF') {
                        e.preventDefault();
                        document.getElementById('fetch').click();
                    } else if (e.code == 'KeyY') {
                        e.preventDefault();
                        doYes();
                    } else if (e.code == 'KeyN') {
                        e.preventDefault();
                        doNo();
                    } else if (e.code == 'KeyG') {
                        e.preventDefault();
                        doChange();
                    } else if (e.code == 'KeyI') {
                        e.preventDefault();
                        document.getElementById('btn-info-open').click();
                    } else if (e.code == 'KeyU') {
                        e.preventDefault();
                        document.querySelector('.dropdown-trigger').click();
                    }
                }, false);

                function doYes(e) {
                    submitForm();
                }

                function doNo(e) {
                    document.querySelector('.options').classList.replace('hide', 'show');
                }

                function doChange(e) {
                    document.querySelector('#fault_type').value = document.querySelector('#fault-type-new').innerText;
                    submitForm();
                }

                function doOption(e) {
                    document.querySelector('.fault-type .buttons .has-background-grey-light').classList.replace('has-background-grey-light', 'has-background-grey-dark');
                    e.target.classList.replace('has-background-grey-dark', 'has-background-grey-light');
                    document.querySelector('.confirm').classList.replace('hide', 'show');
                    document.querySelector('#fault-type-new').innerText = e.target.innerText;
                    document.querySelector('#change').focus({preventScroll: false});
                }

                function submitForm() {
                    console.log('submitForm - iddevices: '
                            + document.querySelector('#iddevices').value
                            + ' / fault_type: '
                            + document.querySelector('#fault_type').value);
                    document.forms['log-task'].submit();
                }

            }, false);
        </script>
    </body>
</html>