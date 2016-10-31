<?php

include("upload.php");


$bannerImageConfig = uploadConfig("bannerImg","BannerImage",5242880);
$cateImageConfig = uploadConfig("cateImg","CategoryImage",5242880);
$articleImageConfig = uploadConfig("artImg","ArticleImage",5242880);
$userHeadConfig = uploadConfig("upFace","Face");

$filmCateConfig = uploadConfig("upFilmCate","FilmCategoryImage");
$filmConfig = uploadConfig("upFilm","FilmImage");

$moviesuffix = array("mov","m4v","mp4","avi","rmvb","rm","wmv","mkv");
$videoUploadConfig = uploadConfig("upVideo","Videos",0,$moviesuffix);

$topicCateConfig = uploadConfig("upTopicCate","TopicCateImage");

return array_merge(
    $userHeadConfig,
    $cateImageConfig,
    $articleImageConfig,
    $bannerImageConfig,
    $filmCateConfig,
    $filmConfig,
    $videoUploadConfig,
    $topicCateConfig
);