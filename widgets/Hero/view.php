<?php
    $settings = $this->get_settings_for_display();
?>

<section class="widget hero">

    <!-- Bootstrap carousel -->

    <div id="heroCarousel" class="carousel slide carousel-fade" data-ride="carousel" data-interval="7000">
        <div class="carousel-inner">
            <?php 
                foreach ($settings["images"] as $key => $image) {
                ?>
                    <div class="carousel-item <?= $key === 0 ? 'active' : ''?>">
                        <img class="d-block w-100" src="<?= $image["url"] ?>" alt="">
                    </div>
                <?php
                }
            ?>
        </div>
    </div>

    <div class="overlay"></div>

    <div class="container">
        <div class="fake"></div>
        <div class="hero-content">
            <h1><?= $settings["title"] ?></h1>
            <h4><?= $settings["subtitle"] ?></h4>
            <div class="search-input">
                <span class="icon mr-4"><?= render_icon("search"); ?></span><span><?= $settings["search_placeholder"] ?></span>
            </div>
        </div>

        <ol class="carousel-indicators">
            <?php 
            foreach ($settings["images"] as $key => $image) {
                ?>
                <li data-target="#heroCarousel" data-slide-to="<?=$key?>" class="<?= $key === 0 ? 'active' : ''?>"></li>
                <?php
            }
            ?>
            
        </ol>
    </div>

    <div class="hero-icons">
        <div class="icon-list">
            <div class="white-skewed"></div>
            <a href="#" class="hero-icon">
                <span><?= render_icon("weather"); ?></span>
                <span><?= __("weather", "kranjskagora") ?></span>
            </a>
            <a href="#" class="hero-icon">
                <span><?= render_icon("camera"); ?></span>
                <span><?= __("webcams", "kranjskagora") ?></span>
            </a>
            <a href="#" class="hero-icon">
                <span><?= render_icon("search"); ?></span>
                <span><?= __("search", "kranjskagora") ?></span>
            </a>
        </div>
    </div>

</section>
