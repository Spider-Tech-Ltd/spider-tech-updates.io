<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Spider Tech</title>
    <link rel="shortcut icon" type="image/x-icon" href="/images/favicon.ico" />
    <link rel="stylesheet" href="/css/animate.css" />
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v3.0.6/css/line.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <link rel="stylesheet" href="/css/flaticon.css" />
    <link rel="stylesheet" href="/css/bootstrap.min.css" />
    <link rel="stylesheet" href="/css/owl.carousel.min.css" />
    <link rel="stylesheet" href="/css/owl.theme.default.min.css" />
    <link rel="stylesheet" href="/css/lightbox.css" />
    <link rel="stylesheet" href="/css/skin-red.css" />
    <link rel="stylesheet" href="/css/header.css" />
    <link rel="stylesheet" href="/css/style.css" />
    <link rel="stylesheet" href="/css/responsive.css" />
    <script src="/js/jquery.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <div id="preloader"><div id="status"><div class="loader"><div class="loader-inner"></div></div></div></div>

<div class="wraper">
  <div class="header-top contact_info">
      <div class="container">
        <div class="col-lg-12 col-md-12">
          <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
              <div class="follow_us_on">
                <ul>
                  <li><a target="_blank" href="https://web.facebook.com/people/Spider-Hub-Spider-Technologies-Limited/61561284852721/" title="Facebook" ><i class="fab fa-facebook-f"></i></a></li>
                  <li class="separator-pipesign white"></li>
                  <li><a href="javascript:void(0)" title="Twitter" ><i class="fab fa-twitter"></i></a></li>
                  <li class="separator-pipesign white"></li>
                  <li><a target="_blank" href="https://www.youtube.com/channel/UCBg_EHRiMiwkJyCuva84zNw" title="Youtube" ><i class="fab fa-youtube"></i></a></li>
                  <li class="separator-pipesign white"></li>
                  <li><a href="javascript:void(0)" title="Linkedin" ><i class="fab fa-linkedin-in"></i></a></li>
                  <li class="separator-pipesign white"></li>
                  <li><a target="_blank" href="https://www.instagram.com/spidertech.hub?igsh=bGhnbWU3OHE5cWtp" title="Instagram" ><i class="fab fa-instagram"></i></a></li>
                </ul>
              </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 mail-call">
              <div class="mail-to"><i class="flat flaticon-mail-black-envelope-symbol"></i><?= $contact['contact_email'] ?? ''; ?></div>
              <span class="separator-pipesign white"></span>
              <div class="call-on"><i class="flat flaticon-phone-receiver"> </i><?= $contact['contact_pno'] ?? ''; ?></div>
            </div>
          </div>
        </div>
      </div>
    </div>
  <header class="header index-2">
    <div class="container">
     <nav class="navbar navbar-expand-lg">
            <h2 class="nav-brand"><a class="navbar-brand" href="/?route=home" title="Spider Tech"><img src="/images/spider-tech.png" class="logo" alt=""> </a></h2>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#nav-content" aria-controls="nav-content" aria-expanded="false" aria-label="Toggle navigation">
              <span class="navbar-toggler-icon"></span><span class="navbar-toggler-icon"></span><span class="navbar-toggler-icon"></span>
            </button>
             <div class="main-menu collapse navbar-collapse d-lg-flex justify-content-lg-between w-100" id="nav-content">
              <ul class="navbar-nav mx-auto text-center">
                <li class="nav-item dropdown active"><a class="nav-link"  href="/?route=home">Home</a></li>
                 <li class="nav-item dropdown"><a class="nav-link"  href="/?route=about">About Us</a></li>
                 <li class="nav-item dropdown"><a class="nav-link" href="/?route=services">Services</a></li>
                <li class="nav-item dropdown"><a class="nav-link"  href="/?route=projects">Projects</a></li>
                <li class="nav-item dropdown">
                  <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#">Events</a>
                  <ul class="dropdown-menu">
                    <li class="dropdown-item"><a href="/?route=events/upcoming">Upcoming Events</a></li>
                    <li class="dropdown-item"><a href="/?route=events/past">Past Events</a></li>
                  </ul>
                </li>
                <li class="nav-item dropdown"><a class="nav-link" href="/?route=trainings">Trainings</a></li>
                 <li class="nav-item dropdown"><a class="nav-link" href="/?route=forum">Forum</a></li>
                 <li class="nav-item dropdown"><a class="nav-link" href="/blog.php">Blog</a></li>
              </ul>
              <div class="text-center mt-3 mt-lg-0 ml-lg-3">
                  <a class="btn text-white px-4 py-2" href="/?route=contact" style="background-color: #f48221; border-radius: 50px; font-weight: 600; box-shadow: 0 4px 10px rgba(244,130,33,0.3);">Contact Us</a>
              </div>
            </div>
          </nav>
    </div>
  </header>
