<?php
/**
 * Template Name: Būsto mugė (registracijos forma)
 *
 * Kopija iš templates/page-contacts.php struktūros: naudoja tą patį
 * releven-form komponentą, stilius (.page-contacts .news ...) ir releven-form.js.
 * Skirtumai: be pomėgių checkbox'ų, "Komentaras" vietoj "Jūsų žinutė",
 * paslėptas form_id=busto-muge (pagal jį įrašai keliauja į Google Sheets,
 * žr. inc/busto-muge-sheets.php) ir planšetės režimas: po sėkmingo
 * pateikimo puslapis po 8 s persikrauna kitam lankytojui.
 */

get_header();

$hz_lines = static function () {
    $foot = '<svg width="14" height="36" viewBox="0 0 14 36" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M9.21875 7.91287V27.3475C9.21875 31.4109 10.9925 34.7257 13.1964 34.7257V35.2604H0V34.7257C2.20389 34.7257 3.97778 31.4109 3.97778 27.3475V7.91287C3.97778 3.84951 2.20389 0.534668 0 0.534668V0H13.2047L13.1964 0.534668C10.9925 0.534668 9.21875 3.84951 9.21875 7.91287Z" fill="#FFFFFF"/></svg>';
    ?>
    <div class="lines dark">
        <div class="lines-wrap">
            <div class="line-left">
                <div class="top"><div class="inner"></div></div>
                <div class="bottom"><div class="inner"></div></div>
            </div>
            <div class="line-center">
                <div class="left flx"><?php echo $foot; ?></div>
                <div class="right flx"><?php echo $foot; ?></div>
            </div>
            <div class="line-right">
                <div class="top"><div class="inner"></div></div>
                <div class="bottom"><div class="inner"></div></div>
            </div>
        </div>
    </div>
    <?php
};

$hz_title = get_the_title() ?: 'SUSISIEKIME';
?>

    <main class="page-contacts page-busto-muge relative">
        <section class="mobile-top relative">
            <?php $hz_lines(); ?>
            <div class="wrapper">
                <h1 class="releven-contact__title"><?php echo esc_html( $hz_title ); ?></h1>
            </div>
        </section>

        <section class="news relative">
            <?php $hz_lines(); ?>
            <div class="wrapper flx jbetween acenter">
                <div class="left flx col" data-releven-contact>
                    <h1 class="releven-contact__title"><?php echo esc_html( $hz_title ); ?></h1>

                    <form class="releven-form" data-releven-form method="post" novalidate>
                        <div aria-hidden="true" style="position:absolute;left:-10000px;top:auto;width:1px;height:1px;overflow:hidden;">
                            <label for="releven-website">Website</label>
                            <input id="releven-website" type="text" name="website" tabindex="-1" autocomplete="off" value="">
                        </div>
                        <input type="hidden" name="form_id" value="busto-muge">
                        <input type="hidden" name="source_url" value="">

                        <!-- NAME (required) -->
                        <div class="releven-form__field" data-field="name">
                            <div class="releven-form__notice" data-notice aria-live="polite"></div>
                            <div class="releven-form__focused">Vardas ir pavardė*</div>
                            <input class="releven-form__control" id="name" name="name" type="text"
                                   placeholder="Vardas ir pavardė*" autocomplete="off" required/>
                        </div>

                        <!-- EMAIL (required) -->
                        <div class="releven-form__field" data-field="email">
                            <div class="releven-form__notice" data-notice aria-live="polite"></div>
                            <div class="releven-form__focused">El. paštas*</div>
                            <input class="releven-form__control" id="email" name="email" type="email"
                                   placeholder="El. paštas*" autocomplete="off" required/>
                        </div>

                        <!-- PHONE (required) -->
                        <div class="releven-form__field" data-field="phone">
                            <div class="releven-form__notice" data-notice aria-live="polite"></div>
                            <div class="releven-form__focused">Telefono numeris*</div>
                            <input class="releven-form__control" id="phone" name="phone" type="tel"
                                   placeholder="Telefono numeris*" autocomplete="off" required/>
                        </div>

                        <!-- MESSAGE (optional) -->
                        <div class="releven-form__field text-area" data-field="message">
                            <div class="releven-form__notice" data-notice aria-live="polite"></div>
                            <div class="releven-form__focused">Komentaras</div>
                            <textarea class="releven-form__control releven-form__control--textarea" id="message"
                                      name="message" placeholder="Komentaras"></textarea>
                        </div>

                        <!-- Privacy (required) -->
                        <div class="releven-form__checks releven-form__checks--2 releven-form__checks--consent"
                             data-field="privacy">
                            <div class="releven-form__notice" data-notice aria-live="polite"></div>
                            <div class="releven-form__check releven-form__check--consent">
                                <input class="releven-form__checkbox" id="privacy" type="checkbox" name="privacy"
                                       value="1" required/>
                                <label class="releven-form__check-label" for="privacy">
                                    Sutinku su <a class="releven-form__link" href="<?php echo esc_url( home_url( '/privatumo-politika/' ) ); ?>" target="_blank" rel="noopener">privatumo politika</a><span class="releven-form__req">*</span>
                                </label>
                            </div>
                        </div>

                        <button class="releven-form__submit" type="submit">Siųsti</button>

                        <div class="releven-form__form-error" data-form-error aria-live="polite"></div>
                    </form>
                </div>

                <div class="right relative">
                    <div class="flx gapx40 row">
                        <?php
                        // Tie patys kontaktai kaip /kontaktai/ puslapyje. Jei ten jie ateina iš ACF,
                        // galima pakeisti tuo pačiu ciklu kaip page-contacts.php.
                        $hz_people = [
                            [
                                'title'   => 'GYVENIMUI',
                                'name'    => 'Izabelė Romanovaitė',
                                'email'   => 'horizontai@releven.lt',
                                'phone'   => '+370 611 17947',
                                'img'     => '/wp-content/uploads/2026/02/image-10.png',
                                'img_mob' => '/wp-content/uploads/2026/02/image-10-4.webp',
                            ],
                            [
                                'title'   => '&nbsp;',
                                'name'    => 'Sandra Grinkienė',
                                'email'   => 'sandra.grinkiene@ober-haus.lt',
                                'phone'   => '+370 685 87595',
                                'img'     => '/wp-content/uploads/2026/02/image-11-2-1.png',
                                'img_mob' => '/wp-content/uploads/2026/02/image-11-4.webp',
                            ],
                        ];
                        foreach ( $hz_people as $p ) : ?>
                            <div class="single flx col" data-fade-container>
                                <div class="top flx col gapy18">
                                    <div class="title" data-fade-item><h3><?php echo $p['title']; ?></h3></div>
                                    <div class="image mobile-hidden">
                                        <img width="644" height="690" src="<?php echo esc_url( home_url( $p['img'] ) ); ?>" alt="" decoding="async">
                                    </div>
                                    <div class="image desktop-hidden">
                                        <img width="1005" height="690" src="<?php echo esc_url( home_url( $p['img_mob'] ) ); ?>" alt="" decoding="async">
                                    </div>
                                </div>
                                <div class="bottom flx col gapy10">
                                    <div class="name" data-fade-item><h5><?php echo esc_html( $p['name'] ); ?></h5></div>
                                    <div class="info flx col" data-fade-item>
                                        <a href="mailto:<?php echo esc_attr( $p['email'] ); ?>"><?php echo esc_html( $p['email'] ); ?></a>
                                        <a href="tel:<?php echo esc_attr( preg_replace( '/\s+/', '', $p['phone'] ) ); ?>"><?php echo esc_html( $p['phone'] ); ?></a>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <script>
        // Planšetės režimas: releven-form.js po sėkmės pašalina formą.
        // Tada po 8 s perkrauname puslapį (švari forma ir naujas nonce kitam lankytojui).
        (function () {
            var form = document.querySelector('.page-busto-muge [data-releven-form]');
            if (!form) return;
            new MutationObserver(function (_, obs) {
                if (!document.body.contains(form)) {
                    obs.disconnect();
                    setTimeout(function () { window.location.reload(); }, 8000);
                }
            }).observe(form.parentNode, { childList: true });
        })();
    </script>

<?php
get_footer();
