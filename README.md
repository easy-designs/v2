# Easy Designs v2 archive

The historical PHP source is retained, but the deployed site is a frozen static
export in `public/`. Do not publish the repository root or execute its old PHP
on a public server.

## Hosting

GitHub Actions validates and deploys **only `public/`** from `master` to GitHub
Pages. In Settings > Pages, use GitHub Actions as the source, not branch
publishing: the branch option only accepts `/` or `/docs`, not `/public`.
Pull requests validate and upload an artifact but do not deploy.

The custom domain is `v2.easy-designs.net`; its DNS CNAME should point to
`easy-designs.github.io`. `public/CNAME` records the domain, which must also be
configured in Pages settings. Enable HTTPS enforcement after GitHub issues
the certificate. No PHP environment or Netlify account is required.

GitHub Pages cannot provide Netlify's HTTP redirects. The custom 404 page
redirects all 21 historical PHP URLs to canonical archive pages with JavaScript,
preserving queries and fragments. The initial response remains HTTP 404 rather
than 301; without JavaScript, visitors receive the archive-home link. Unknown
URLs remain on the 404 page. Normal archive pages work without this redirect.
The existing `netlify.toml` and `public/_redirects` remain available for an
optional Netlify deployment with true HTTP redirects; Pages ignores those rules.

## Preservation notes

Public PHP pages were rendered in a read-only, network-isolated PHP 5.6
container with short tags enabled and UTC configured. HTML output, client-side
examples, ZIP downloads, and legacy media are committed so future deployment
requires no PHP environment or access to the retired server.

Server-backed Ajax/form examples are explicitly archival. The gFSS PHP demo
links to the surviving client-side example. Old analytics were removed.
Locally saved A List Apart and Digital Web articles retain their original
external link bases instead of resolving those publishers' navigation here.

The generated common pages load the existing jsUtilities prerequisite before
the footnote scripts, restoring their original intended dependency order.

The surviving repository did not contain the formSuite ZIP, working
formSuite.js, custom DTD, or the advertised jsTrace 1.3 drag ZIP. Their links
are explicitly marked unavailable, not replaced with incorrect versions. The
original sources remain untouched outside `public/` for future recovery.
The former portfolio link points to the preserved Easy Designs portfolio.

## Validation and maintenance

`migration-manifest.json` records the source commit and PHP route map.
GitHub Actions checks the artifact boundary and disallows PHP/SQL/source
configuration and ed-cdn.com dependencies in the public artifact.

```sh
python3 -m http.server 8080 --directory public
```

The local server does not serve the custom 404 automatically or interpret
`_redirects`; test historical PHP URLs on Pages. Keep a private backup and the
previous origin until live DNS, TLS, content, and media checks are complete.
