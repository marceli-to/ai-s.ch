# Multisite (DE/FR) — content migration runbook

This is the step-by-step for re-applying the **content-folder** changes that the
DE/FR multisite conversion requires. The code/config side lives in git and
deploys normally; the content side does **not** and must be redone whenever the
content is re-pulled from production.

## Why this document exists

`/content` is **gitignored** and managed pull-only by `marceli-to/statamic-sync`
(`php please statamic:pull`). **Production is the source of truth.** See the
project memory notes `content-sync-architecture` and `multisite-de-fr-setup`.

When this was first done (2026-06), the multisite conversion was split:

- **Code/config** (tracked, deploys via git) — commit `3523689`.
- **Content restructuring** (gitignored, NOT in git) — done by hand locally.

The project is now on hold. Production is still **single-site**, and editors may
keep updating content there. When work resumes:

1. A fresh `statamic:pull` will bring down **single-site** content and **wipe the
   local multisite restructuring** (entries move back to flat folders, `sites:`
   keys and `fr/` trees disappear).
2. To go live, the same restructuring must be **replayed on production** — pushing
   the config alone crashes prod with `Undefined array key 1` in
   `CollectionEntriesStore`, because the entries aren't in per-site folders yet.

So the content steps below will need to be redone at least once more. This is the
checklist to do it fast.

---

## Part 1 — Code/config (already in git, commit `3523689`)

Nothing to redo here on a pull — these are tracked files. Listed so you can verify
they're present and understand what the content has to match.

| File | Change |
|------|--------|
| `config/statamic/system.php` | `'multisite' => true` |
| `resources/sites.yaml` | defines `de` (name "Deutsch", locale `de`, url `/`) and `fr` (name "Französisch", locale `fr`, url `/fr`) |
| `resources/views/partials/menu/wrapper.antlers.html` | language switcher via `{{ locales all="true" current_first="false" }}` |
| `resources/blueprints/collections/pages/page.yaml` | `localizable: true` on `title`, `page_elements`, `open_graph_title`, `open_graph_description`, `open_graph_image` |
| `resources/blueprints/collections/inventory/inventory.yaml` | `localizable: true` on `name`, `firstname`, `bio_text`, `bio_media`, `work_text`, `work_media`, `video_text`, `video_media`, `title` |
| `resources/blueprints/collections/events/event.yaml` | `localizable: true` on `title`, `location`, `text` |
| `resources/blueprints/collections/posts/post.yaml` | `localizable: true` on `title` |
| `resources/fieldsets/media.yaml` | `localizable: true` on `media` |

**Rule of thumb for blueprints:** only top-level *content* fields are localizable.
Structural/settings fields (slugs, toggles, theme, dates, layout choices) stay
shared across sites — leave them alone.

Statamic requires a Pro license for multisite — make sure prod is licensed.

---

## Part 2 — Content restructuring (the part that gets wiped by a pull)

After a fresh pull you start from single-site content: entries in flat collection
folders (`content/collections/<c>/*.md`), collection configs with no `sites:`,
globals/trees with no per-site split. Apply the following.

> **Recommended path:** do it through the Statamic CP rather than editing files by
> hand — adding the site to a collection and using "Localize"/translate in the CP
> writes all the files below correctly. The file-level detail here is for
> verification and for understanding what the CP produces.

### 2a. Collection configs — add `sites:`

In each `content/collections/<c>.yaml`, add both sites:

```yaml
sites:
  - de
  - fr
```

Applies to: `pages.yaml`, `events.yaml`, `inventory.yaml` (and `posts.yaml` if/when
that collection has entries). `pages` keeps `structure: { root: true }`.

### 2b. Move entries into per-site folders

Default site (`de`) entries move into a `de/` subfolder; the `fr` site gets its own
`fr/` subfolder.

```
content/collections/pages/*.md      →  content/collections/pages/de/*.md
content/collections/events/*.md     →  content/collections/events/de/*.md
content/collections/inventory/*.md  →  content/collections/inventory/de/*.md
```

### 2c. Create the FR entries

For **pages**, every DE entry has an FR counterpart in `content/collections/pages/fr/`
(16 of them at last count). Each FR entry is a thin localization that **inherits**
from its DE origin:

```yaml
---
id: <new-uuid-for-the-fr-localization>
origin: <id-of-the-matching-DE-entry>   # e.g. "home", or the DE entry's uuid
published: false                          # FR starts unpublished/empty until translated
title: <copied/translated title>
updated_by: <user-uuid>
updated_at: <timestamp>
---
```

The FR file shares the **same filename/slug** as its DE counterpart (e.g.
`pages/de/archiv.md` ↔ `pages/fr/archiv.md`). Only localizable fields get FR values;
everything else falls through to the DE origin.

**Events and inventory:** at last count these had **no FR entries** — only the `de/`
folder plus `sites: [de, fr]` in the config. Create FR localizations later as needed,
same `origin:`/`published: false` pattern.

### 2d. Globals — per-site split

```
content/globals/de/global_text.yaml   # the actual DE values
content/globals/fr/global_text.yaml   # just:  origin: de   (inherits DE until translated)
```

`content/globals/global_text.yaml` keeps only the set's meta (`title: 'Globale Texte'`).

### 2e. Trees — per-site split

Statamic splits trees by site once multisite is on:

- **Navigation trees** move under a site folder for *both* sites:
  - `content/trees/navigation/de/main.yaml`
  - `content/trees/navigation/fr/main.yaml` (FR titles + `/fr/...` urls, entry ids
    pointing at the FR localizations)
- **Collection trees**: the default site stays at the root path, FR gets a subfolder:
  - `content/trees/collections/pages.yaml` (DE)
  - `content/trees/collections/fr/pages.yaml` (FR — references the FR entry ids)

  `events.yaml` / `inventory.yaml` collection trees stay single (DE) until FR entries
  exist for them.

---

## Part 3 — Verify

- `/` serves DE; `/fr` serves the French site (404s on pages with no published FR
  entry yet — expected, FR starts empty).
- Language switcher renders DE/FR in the main menu and links to each page's
  counterpart.
- CP shows the site dropdown and each localizable collection lists both DE and FR.
- No `Undefined array key 1` errors (that means entries aren't in per-site folders).

---

## Doing this ON PRODUCTION (going live)

Because content can't be pushed via git, the migration must be performed against
production's own content:

1. Deploy the Part 1 code/config via git **together with** the content migration —
   never deploy the config to a prod that still has flat, single-site content.
2. Easiest: enable multisite in the CP on prod and do 2a–2e there, or run the
   migration on a copy of prod content and place it on the server.
3. Take a content backup first. Once multisite is live on prod, the local
   `statamic:pull` will start bringing down the multisite structure and this whole
   runbook is no longer needed.
