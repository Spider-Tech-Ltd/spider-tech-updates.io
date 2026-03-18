<?php
   $contact_details = $conn->prepare("SELECT * FROM `contact_details` WHERE contact_id = 1 LIMIT 1");
   $contact_details->execute();
   $fetch_contact = $contact_details->fetch(PDO::FETCH_ASSOC);
   

   $slider_image1 = $conn->prepare("SELECT * FROM `banners_tb` WHERE banner_id = 1 ");
   $slider_image1->execute();
   $fetch_image1 = $slider_image1->fetch(PDO::FETCH_ASSOC);

   $slider_image2 = $conn->prepare("SELECT * FROM `banners_tb` WHERE banner_id = 2 ");
   $slider_image2->execute();
   $fetch_image2 = $slider_image2->fetch(PDO::FETCH_ASSOC);

   $slider_image3 = $conn->prepare("SELECT * FROM banners_tb WHERE banner_id= 3");
   $slider_image3->execute();
   $fetch_image3 = $slider_image3->fetch(PDO::FETCH_ASSOC);

   $slider_image4 = $conn->prepare("SELECT * FROM `banners_tb` WHERE banner_id = 4 ");
   $slider_image4->execute();
   $fetch_image4 = $slider_image4->fetch(PDO::FETCH_ASSOC);  

   $about_info = $conn->prepare("SELECT * FROM `about_info` WHERE id = 1 LIMIT 1");
   $about_info->execute();
   $fetch_about = $about_info->fetch(PDO::FETCH_ASSOC);

   $about_info2 = $conn->prepare("SELECT * FROM `about_info` WHERE id = 2 LIMIT 1");
   $about_info2->execute();
   $fetch_about2 = $about_info2->fetch(PDO::FETCH_ASSOC);

   $about_info3 = $conn->prepare("SELECT * FROM `about_info` WHERE id = 3 LIMIT 1");
   $about_info3->execute();
   $fetch_about3 = $about_info3->fetch(PDO::FETCH_ASSOC);

   $about_info4 = $conn->prepare("SELECT * FROM `about_info` WHERE id = 4 LIMIT 1");
   $about_info4->execute();
   $fetch_about4 = $about_info4->fetch(PDO::FETCH_ASSOC);

   $about_info5 = $conn->prepare("SELECT * FROM `about_info` WHERE id = 5 LIMIT 1");
   $about_info5->execute();
   $fetch_about5 = $about_info5->fetch(PDO::FETCH_ASSOC);

   $services_query = $conn->query("SELECT DISTINCT service_name FROM services_tb");
   $services = $services_query->fetchAll(PDO::FETCH_ASSOC);

   $events = $conn->prepare("SELECT * FROM `events`");
   $events->execute();
   $fetch_event = $events->fetch(PDO::FETCH_ASSOC);

   $select_training = $conn->prepare("SELECT * FROM trainings_tb");
   $select_training->execute();
   $fetch_training = $select_training->fetch(PDO::FETCH_ASSOC);

?>