# Claude Notes — Shapiro Negotiations Institute (sg-sni)

Quick-start context for picking up SNI work in a fresh session. **Read
this whole file before doing anything**, then read referenced docs as
needed.

---

## What this is

- **Client:** Shapiro Negotiations Institute (SNI) — negotiation,
  influence, and sales training for Fortune 500 corporates.
- **Live site being migrated FROM:** https://stage.shapironegotiations.com/
  (Astra + Elementor stack; ~70 pages + ~1,063 blog posts since 2008).
- **WordPress install on WP Engine:** `sni1`
- **Live URL (sandbox):** https://sni1.wpengine.com/
- **Local mirror:** `/Users/chris/Local Sites/shapiro-negotiations/`
  (Local by Flywheel; site root at `app/public/`)
- **Active theme:** `sg-sni` (child) inheriting from `classic-city-core`
  (parent, via git subtree)

---

## First — orient yourself

1. Read **`wp-content/themes/classic-city-core/docs/ARCHITECTURE.md`**
   for multi-repo + subtree topology.
2. Read **`wp-content/themes/classic-city-core/docs/CLIENT_ONBOARDING.md`**
   especially **Phase 12 — Deploy content programmatically**. Same
   playbook used for TexBuilt; same gotchas apply on this install.
3. Skim Common Pitfalls in the same doc — WPE WAF, cache purging,
   auth header restoration, etc.

---

## Git remotes

- **origin:** `git@github.com:classiccity/ccc-wp-theme--sni.git`
  (PUBLIC, SSH, source of truth)
- **wpe:** `git@git.wpengine.com:production/sni1.git`
  (deploys to WPE production; SSH key registered per-install)
- **upstream-parent:** `git@github.com:classiccity/ccc-wp-theme.git`
  (parent theme — subtree pull to bring in updates)

All SSH-keyed; no credentials needed beyond `~/.ssh/id_ed25519`.

---

## What's in this child theme

### Custom Post Types (SNI-specific, registered here NOT in core)
- **`team_member`** — bios for both team and speakers. Single taxonomy
  `sni_team_role` with two terms (`team-member`, `speaker`) — a person
  can have both. Single template renders ACF sidebar + full Gutenberg
  body. URL: `/who-we-are/{slug}/`. See `inc/cpt-team-member.php`.
- **`case_study`** — client engagements. Taxonomy `sni_industry`.
  URL: `/clients/{slug}/`. See `inc/cpt-case-study.php`.
- **`book`** — books by team members. URL: `/resources/books/{slug}/`.
  See `inc/cpt-book.php`.

The parent's `testimonial` CPT is still active (used by parent's
Testimonial Cards block) — keep it.

### New blocks (in `blocks/`)
- `faq` — accordion (details/summary). Repeater of question/answer.
- `team-grid` — dynamic query of team_member CPT. Filter by
  `sni_team_role` term to render the same component as either the
  Who We Are roster or the Keynote speaker grid.
- `gravity-form` — wrapper around a Gravity Form ID, styled to theme.
- `linked-logo-grid` — queries `case_study` CPT, renders clickable
  logo grid for the `/clients/` index page.
- `inline-video` — responsive 16:9 video block with poster + caption.

### Block patterns (in `inc/patterns.php`)
- `sni/industry-page` — stamps the 8-block recipe used identically on
  all 7 industry pages (Hero → Logo Strip → Split → Value Bullets →
  Role List → Testimonial → Differentiators → CTA).
- `sni/service-opener` — Hero + Split intro used identically on all
  5 service pages.

### Single CPT templates (in `templates/`)
- `single-team_member.html` — sticky-sidebar layout: ACF fields on
  left, Gutenberg `the_content()` on right.
- `single-case_study.html` — case study spine (client logo hero →
  challenge/approach/results → stats strip → testimonials).
- `single-book.html` — cover + title + buy links + description.

Archives are NOT used — `/who-we-are/`, `/clients/`, `/resources/books/`
are regular pages that include the corresponding dynamic block to
render the grid.

---

## Brand reference

From `theme.json` (extracted from the existing Astra + Elementor site's
global colors at post-5.css):

- **CTA / accent:** `#D79851` (warm tan/gold)
- **CTA-alt (hover):** `#B07634`
- **Primary:** `#183F36` (deep forest green)
- **Primary-alt:** `#066D58` (lighter forest)
- **Secondary:** `#005077` (navy)
- **Secondary-alt:** `#14628A` (lighter navy)
- **Light:** `#FFFFFF`
- **Light-alt:** `#EFF5FD` (pale info blue)
- **Dark:** `#000000`
- **Dark-alt:** `#51676E` (slate gray text)

- **Heading font:** `Plus Jakarta Sans` 600 (Google Fonts)
- **Body font:** `Inter` 400 (Google Fonts)
- These were extracted by reading the live site's *rendered* Astra
  inline styles, not the Elementor kit declarations (which list
  Roboto/Roboto Slab but are overridden by Astra). Body base size is
  18px to match staging; H1=64, H2=48, H3=24, H4=20, H5=18, H6=15.
- No accent script font (different from TexBuilt — SNI is polished
  B2B, not industrial).
- **Border default-width:** 1px (thin/polished, vs. TexBuilt's 3px)
- **Radius default:** 4px (slightly rounded, vs. TexBuilt's 0)
- **Shadow style:** soft drop shadows (`0 4px 12px rgba(0,0,0,0.08)`
  etc), not flat offsets — softer, polished feel.
- **FontAwesome icon style:** regular
- **Diagonal divider:** SNI brand signature. Implemented as block
  styles `is-style-diagonal-divider-bottom` and
  `is-style-diagonal-divider-top` on `core/group`. CSS in `style.css`
  uses `clip-path`. Use them paired (one cuts bottom, next cuts top)
  to mirror the slant across section boundaries.

Logo URLs (from staging):
- `https://stage.shapironegotiations.com/wp-content/uploads/2025/10/Shapiro-Negotiations-Training-Logo.png`
- `https://stage.shapironegotiations.com/wp-content/uploads/2025/10/Shapiro-Negotiations-Training-Logo-White.png`

Need to upload these into the WPE install's Media Library + set as
Site Logo before launch.

---

## Working from this site

- Repo root is `/Users/chris/Local Sites/shapiro-negotiations/app/public/`
- The git repo is at the **site root**, not the themes folder
- Whitelist `.gitignore` versions only:
  - `wp-content/themes/classic-city-core/` (parent theme via subtree)
  - `wp-content/themes/sg-sni/` (this child theme)
  - `wp-content/mu-plugins/ccc-fix-auth-header.php`
- Anything else (WP core, plugins, uploads) is untracked.

To deploy code changes:
```
edit → git add → commit → git push origin main && git push wpe main
```

---

## Outstanding manual TODOs

Tracked as the migration progresses:

- ⚠️ **Register SSH key on WPE Git Push tab** for the `sni1` install
  (manual: User Portal → install → Git Push → paste
  `~/.ssh/id_ed25519.pub`). Required before `git push wpe main` works.
- ⚠️ **Install default plugins** (ACF Pro, Gravity Forms, Yoast) via
  Phase 1b of the onboarding runbook once Git Push works.
- ⚠️ **Pull from WP Engine** in Local once after plugins are
  installed, so Local has ACF/GF and blocks render correctly in the
  Local editor preview.
- ⚠️ **Upload Shapiro logos** to Media Library, set as Site Identity logo.
- ⚠️ **Activate `sg-sni`** in `Appearance → Themes` once it pushes.
- Blog migration: WXR export from `stage.shapironegotiations.com`
  (1,063 posts), import to WPE, then run author-reassignment cleanup
  for the ~5% legacy multi-author byline drift.

---

## What NOT to do

- ❌ Don't add SNI-specific code to `classic-city-core/` — the parent
  is shared across all CCC clients. SNI things go in this child theme.
- ❌ Don't try to `POST /wp/v2/media` — WPE WAF will 403 you. Use
  `wp media import` over SSH Gateway (same pattern as TexBuilt).
- ❌ Don't try to `POST /wp/v2/pages` for new content — same WAF.
- ❌ Don't forget the Varnish cache purge after wp-cli content changes.
- ❌ Don't commit secrets (license keys, app passwords) to git.
- ❌ Don't edit ACF field keys that are already in use without a
  migration plan — block content stores keys directly.

---

## Key reference files

- **Parent theme runbook:** `wp-content/themes/classic-city-core/docs/CLIENT_ONBOARDING.md`
- **Parent theme architecture:** `wp-content/themes/classic-city-core/docs/ARCHITECTURE.md`
- **TexBuilt parallel:** `~/Local Sites/texbuilt/app/public/wp-content/themes/sg-texbuilt/CLAUDE.md` (good reference for any "how did we do this on TexBuilt" question — the WPE patterns are identical).
