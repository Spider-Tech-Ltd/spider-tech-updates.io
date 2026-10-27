<!-- ====== Partnership Logos Tier Section ====== -->
<section class="partners-logo-section" aria-label="Our Partners and Collaborators">
    <div class="container">
        <div class="partners-tier-header">
            <span class="partners-tier-label">
                <svg class="partners-headline-sep" width="38" height="12" viewBox="0 0 38 12" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                    <rect x="0" y="1.5" width="3" height="9" rx="0.5" fill="#f48221"/>
                    <rect x="4" y="5.25" width="34" height="1.5" rx="0.5" fill="#cbd5e1"/>
                </svg>
                <span class="partners-tier-label-text">Trusted Partners &amp; Collaborators</span>
                <svg class="partners-headline-sep" width="38" height="12" viewBox="0 0 38 12" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                    <rect x="0" y="5.25" width="34" height="1.5" rx="0.5" fill="#cbd5e1"/>
                    <rect x="35" y="1.5" width="3" height="9" rx="0.5" fill="#f48221"/>
                </svg>
            </span>
        </div>
        <?php $hasAdminPartners = !empty($partners) && is_array($partners); ?>
        <div class="partners-marquee-viewport">
            <div class="partners-marquee-track">
                <?php for ($g = 0; $g < 2; $g++): ?>
                <div class="partners-marquee-group" <?= $g === 1 ? 'aria-hidden="true"' : '' ?>>
                    <?php if ($hasAdminPartners):
                        $minLogos = 7;
                        $rep = (int) max(1, ceil($minLogos / count($partners)));
                        for ($r = 0; $r < $rep; $r++):
                            foreach ($partners as $partner):
                                $pName = trim(stripslashes($partner['name'] ?? 'Partner'));
                                $rawLogo = trim($partner['logo'] ?? '');
                                $logoUrl = '';
                                if ($rawLogo !== '') {
                                    $logoUrl = preg_match('#^https?://#i', $rawLogo)
                                        ? $rawLogo
                                        : BASE_URL . '/' . ltrim($rawLogo, './');
                                }
                    ?>
                        <div class="partner-ticker-item" title="<?= htmlspecialchars($pName); ?>">
                            <?php if ($logoUrl !== ''): ?>
                                <img src="<?= htmlspecialchars($logoUrl); ?>"
                                     alt="<?= htmlspecialchars($pName); ?>"
                                     class="partner-logo-img"
                                     loading="lazy"
                                     decoding="async">
                            <?php else: ?>
                                <span class="partner-fallback-wordmark"><?= htmlspecialchars($pName); ?></span>
                            <?php endif; ?>
                        </div>
                    <?php
                            endforeach;
                        endfor;
                    else: ?>
                        <!-- Placeholder SVG Brand Logotypes (Replaced automatically when logos are added in Admin) -->
                        <div class="partner-ticker-item" title="Partner Placeholder">
                            <svg class="partner-svg-logo" viewBox="0 0 156 36" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <rect x="2" y="6" width="24" height="24" rx="6" stroke="currentColor" stroke-width="2.5"/>
                                <path d="M9 18L13 22L20 14" stroke="#f48221" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
                                <text x="36" y="23" fill="currentColor" font-family="Poppins, sans-serif" font-weight="700" font-size="15" letter-spacing="-0.3"> CoreSystems</text>
                            </svg>
                        </div>
                        <div class="partner-ticker-item" title="Partner Placeholder">
                            <svg class="partner-svg-logo" viewBox="0 0 148 36" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <circle cx="14" cy="18" r="11" stroke="currentColor" stroke-width="2.5"/>
                                <circle cx="14" cy="18" r="4.5" fill="#f48221"/>
                                <text x="34" y="23" fill="currentColor" font-family="Poppins, sans-serif" font-weight="700" font-size="15" letter-spacing="-0.3">NexusGrid</text>
                            </svg>
                        </div>
                        <div class="partner-ticker-item" title="Partner Placeholder">
                            <svg class="partner-svg-logo" viewBox="0 0 152 36" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M14 6L26 13V23L14 30L2 23V13L14 6Z" stroke="currentColor" stroke-width="2.5" stroke-linejoin="round"/>
                                <path d="M14 13V23M9 16L14 13L19 16" stroke="#f48221" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"/>
                                <text x="35" y="23" fill="currentColor" font-family="Poppins, sans-serif" font-weight="700" font-size="15" letter-spacing="-0.3">VertexLabs</text>
                            </svg>
                        </div>
                        <div class="partner-ticker-item" title="Partner Placeholder">
                            <svg class="partner-svg-logo" viewBox="0 0 156 36" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M4 24L12 10L20 24H4Z" stroke="currentColor" stroke-width="2.5" stroke-linejoin="round"/>
                                <path d="M15 24L21 14L27 24H15Z" fill="#f48221" fill-opacity="0.85"/>
                                <text x="35" y="23" fill="currentColor" font-family="Poppins, sans-serif" font-weight="700" font-size="15" letter-spacing="-0.3">ApexDigital</text>
                            </svg>
                        </div>
                        <div class="partner-ticker-item" title="Partner Placeholder">
                            <svg class="partner-svg-logo" viewBox="0 0 154 36" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <rect x="3" y="8" width="10" height="20" rx="3" stroke="currentColor" stroke-width="2.4"/>
                                <rect x="16" y="13" width="10" height="15" rx="3" stroke="#f48221" stroke-width="2.4"/>
                                <text x="35" y="23" fill="currentColor" font-family="Poppins, sans-serif" font-weight="700" font-size="15" letter-spacing="-0.3">StrataCloud</text>
                            </svg>
                        </div>
                        <div class="partner-ticker-item" title="Partner Placeholder">
                            <svg class="partner-svg-logo" viewBox="0 0 150 36" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M6 18C6 11.9249 10.9249 7 17 7C23.0751 7 28 11.9249 28 18" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"/>
                                <path d="M11 23C11 19.6863 13.6863 17 17 17C20.3137 17 23 19.6863 23 23" stroke="#f48221" stroke-width="2.5" stroke-linecap="round"/>
                                <circle cx="17" cy="26" r="2" fill="currentColor"/>
                                <text x="36" y="23" fill="currentColor" font-family="Poppins, sans-serif" font-weight="700" font-size="15" letter-spacing="-0.3">PulseNet</text>
                            </svg>
                        </div>
                    <?php endif; ?>
                </div>
                <?php endfor; ?>
            </div>
        </div>
    </div>
</section>
