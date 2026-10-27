<!-- ====== Testimonials Section ====== -->
<section class="section-padding testimonials-marquee-section">
    <div class="container">
        <div class="section-header text-center mb-4">
            <span class="section-eyebrow">
                <svg class="eyebrow-line-svg" width="38" height="12" viewBox="0 0 38 12" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                    <rect x="0" y="1.5" width="3" height="9" rx="0.5" fill="#f48221"/>
                    <rect x="4" y="5.25" width="34" height="1.5" rx="0.5" fill="#cbd5e1"/>
                </svg>
                <span class="eyebrow-label-text">Client Testimonials</span>
                <svg class="eyebrow-line-svg" width="38" height="12" viewBox="0 0 38 12" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                    <rect x="0" y="5.25" width="34" height="1.5" rx="0.5" fill="#cbd5e1"/>
                    <rect x="35" y="1.5" width="3" height="9" rx="0.5" fill="#f48221"/>
                </svg>
            </span>
            <br>
            <h2 class="section-title">What <span>Clients Say</span></h2>
            <p class="section-subtitle">Trusted by industry leaders to deliver excellence and technical innovation.</p>
        </div>
    </div>

    <?php
    if (!function_exists('truncateTestimonialWordAware')) {
        function truncateTestimonialWordAware($text, $limit = 118) {
            $text = trim(preg_replace('/\s+/', ' ', strip_tags(stripslashes($text))), " \"'\t\n\r\0\x0B");
            if ($text === '' || mb_strlen($text) <= $limit) {
                return $text;
            }
            $truncated = mb_substr($text, 0, $limit);
            $lastSpace = mb_strrpos($truncated, ' ');
            if ($lastSpace !== false) {
                $truncated = mb_substr($truncated, 0, $lastSpace);
            }
            $truncated = rtrim($truncated, ".,;:- ");
            return $truncated . '...';
        }
    }

    if (!function_exists('getClientInitials')) {
        function getClientInitials($name) {
            $parts = preg_split('/\s+/', trim(stripslashes($name)));
            $initials = '';
            foreach ($parts as $p) {
                if ($p !== '') {
                    $initials .= mb_strtoupper(mb_substr($p, 0, 1));
                }
                if (mb_strlen($initials) >= 2) break;
            }
            return $initials !== '' ? $initials : 'ST';
        }
    }

    $baseTestimonials = !empty($testimonials) ? array_values($testimonials) : [];
    $row1Items = [];
    $row2Items = [];

    if (!empty($baseTestimonials)) {
        $minCardsPerGroup = 6;
        $repeatCount = (int) max(2, ceil($minCardsPerGroup / count($baseTestimonials)));
        for ($i = 0; $i < $repeatCount; $i++) {
            foreach ($baseTestimonials as $item) {
                $row1Items[] = $item;
            }
        }
        $reversedTestimonials = array_reverse($baseTestimonials);
        if (count($reversedTestimonials) > 1) {
            $first = array_shift($reversedTestimonials);
            $reversedTestimonials[] = $first;
        }
        for ($i = 0; $i < $repeatCount; $i++) {
            foreach ($reversedTestimonials as $item) {
                $row2Items[] = $item;
            }
        }
    }
    ?>

    <?php if (!empty($baseTestimonials)): ?>
    <div class="testimonial-marquee-viewport">
        <!-- Row 1: Moves Right -->
        <div class="testimonial-marquee-row">
            <div class="testimonial-marquee-track track-move-right">
                <?php for ($groupIdx = 0; $groupIdx < 2; $groupIdx++): ?>
                <div class="testimonial-marquee-group" <?= $groupIdx === 1 ? 'aria-hidden="true"' : '' ?>>
                    <?php foreach ($row1Items as $testimonial):
                        $cleanQuote = truncateTestimonialWordAware($testimonial['testimonial'], 118);
                        $cName = trim(stripslashes($testimonial['name'] ?? 'Client'));
                        $cTitle = trim(stripslashes($testimonial['title'] ?? ''));
                        $cOrg = trim(stripslashes($testimonial['organization'] ?? ''));
                        $cInitials = getClientInitials($cName);
                    ?>
                        <article class="testimonial-slide-new">
                            <div class="quote-icon" aria-hidden="true">
                                <svg class="quote-svg" viewBox="0 0 48 48" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M14.4 22.8C17.7137 22.8 20.4 25.4863 20.4 28.8C20.4 32.1137 17.7137 34.8 14.4 34.8C10.4235 34.8 7.2 31.5765 7.2 27.6C7.2 19.6471 12.1412 14.1882 18.2118 12.1412C19.0588 11.8588 19.9059 12.4235 20.0471 13.2706C20.1882 14.1176 19.7647 14.9647 18.9176 15.2471C14.6824 16.6588 11.7176 19.7647 11.1529 24.0706C12.1412 23.2235 13.2706 22.8 14.4 22.8ZM34.8 22.8C38.1137 22.8 40.8 25.4863 40.8 28.8C40.8 32.1137 38.1137 34.8 34.8 34.8C30.8235 34.8 27.6 31.5765 27.6 27.6C27.6 19.6471 32.5412 14.1882 38.6118 12.1412C39.4588 11.8588 40.3059 12.4235 40.4471 13.2706C40.5882 14.1176 40.1647 14.9647 39.3176 15.2471C35.0824 16.6588 32.1176 19.7647 31.5529 24.0706C32.5412 23.2235 33.6706 22.8 34.8 22.8Z"/>
                                </svg>
                            </div>
                            <p class="testimonial-text">
                                "<?= htmlspecialchars($cleanQuote); ?>"
                            </p>
                            <div class="client-info-v2">
                                <div class="client-avatar-v2" aria-hidden="true">
                                    <span><?= htmlspecialchars($cInitials); ?></span>
                                </div>
                                <div class="client-meta-v2">
                                    <h4 class="client-name-v2"><?= htmlspecialchars($cName); ?></h4>
                                    <p class="client-job-v2">
                                        <span class="client-role-title"><?= htmlspecialchars($cTitle); ?></span><?php if ($cTitle !== '' && $cOrg !== ''): ?><span class="client-role-sep">, </span><?php endif; ?><span class="client-role-org"><?= htmlspecialchars($cOrg); ?></span>
                                    </p>
                                </div>
                            </div>
                        </article>
                    <?php endforeach; ?>
                </div>
                <?php endfor; ?>
            </div>
        </div>

        <!-- Row 2: Moves Left (Alternate Direction) -->
        <div class="testimonial-marquee-row">
            <div class="testimonial-marquee-track track-move-left">
                <?php for ($groupIdx = 0; $groupIdx < 2; $groupIdx++): ?>
                <div class="testimonial-marquee-group" <?= $groupIdx === 1 ? 'aria-hidden="true"' : '' ?>>
                    <?php foreach ($row2Items as $testimonial):
                        $cleanQuote = truncateTestimonialWordAware($testimonial['testimonial'], 118);
                        $cName = trim(stripslashes($testimonial['name'] ?? 'Client'));
                        $cTitle = trim(stripslashes($testimonial['title'] ?? ''));
                        $cOrg = trim(stripslashes($testimonial['organization'] ?? ''));
                        $cInitials = getClientInitials($cName);
                    ?>
                        <article class="testimonial-slide-new">
                            <div class="quote-icon" aria-hidden="true">
                                <svg class="quote-svg" viewBox="0 0 48 48" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M14.4 22.8C17.7137 22.8 20.4 25.4863 20.4 28.8C20.4 32.1137 17.7137 34.8 14.4 34.8C10.4235 34.8 7.2 31.5765 7.2 27.6C7.2 19.6471 12.1412 14.1882 18.2118 12.1412C19.0588 11.8588 19.9059 12.4235 20.0471 13.2706C20.1882 14.1176 19.7647 14.9647 18.9176 15.2471C14.6824 16.6588 11.7176 19.7647 11.1529 24.0706C12.1412 23.2235 13.2706 22.8 14.4 22.8ZM34.8 22.8C38.1137 22.8 40.8 25.4863 40.8 28.8C40.8 32.1137 38.1137 34.8 34.8 34.8C30.8235 34.8 27.6 31.5765 27.6 27.6C27.6 19.6471 32.5412 14.1882 38.6118 12.1412C39.4588 11.8588 40.3059 12.4235 40.4471 13.2706C40.5882 14.1176 40.1647 14.9647 39.3176 15.2471C35.0824 16.6588 32.1176 19.7647 31.5529 24.0706C32.5412 23.2235 33.6706 22.8 34.8 22.8Z"/>
                                </svg>
                            </div>
                            <p class="testimonial-text">
                                "<?= htmlspecialchars($cleanQuote); ?>"
                            </p>
                            <div class="client-info-v2">
                                <div class="client-avatar-v2" aria-hidden="true">
                                    <span><?= htmlspecialchars($cInitials); ?></span>
                                </div>
                                <div class="client-meta-v2">
                                    <h4 class="client-name-v2"><?= htmlspecialchars($cName); ?></h4>
                                    <p class="client-job-v2">
                                        <span class="client-role-title"><?= htmlspecialchars($cTitle); ?></span><?php if ($cTitle !== '' && $cOrg !== ''): ?><span class="client-role-sep">, </span><?php endif; ?><span class="client-role-org"><?= htmlspecialchars($cOrg); ?></span>
                                    </p>
                                </div>
                            </div>
                        </article>
                    <?php endforeach; ?>
                </div>
                <?php endfor; ?>
            </div>
        </div>
    </div>
    <?php endif; ?>
</section>
