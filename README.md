# Easy Designs v2 archive

The historical PHP source is retained, but the deployed site is a frozen static
export in `public/`. Do not publish the repository root or execute its old PHP
on a public server.

## Hosting

Connect the repository to Netlify, deploy `master`, and publish `public`.
`netlify.toml` sets the publish directory, and `public/_redirects` maps the old
PHP entry points to their rendered static pages. Netlify is selected over
GitHub Pages to preserve those URLs with real HTTP redirects rather than
PHP downloads, soft-404 redirects, or broken backend requests.

Add `v2.easy-designs.net` as the custom domain and use the subdomain DNS target
Netlify supplies. The old DNS target was a different origin from the other
sites and did not respond during export. Do not replace it with Pages A records
for a Netlify deployment.

## Preservation notes

Public PHP pages were rendered in a read-only, network-isolated PHP 5.6
container with short tags enabled and UTC configured. HTML output, client-side
examples, ZIP downloads, and legacy media are committed so future deployment
requires no PHP environment or access to the retired server.

Server-backed Ajax/form examples are explicitly archival. The gFSS PHP demo
links to the surviving client-side example. Old analytics were removed.
Locally saved A List Apart and Digital Web articles retain their original
external link bases instead of resolving those publishers' navigation here.

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

Check Netlify preview redirect status, destinations, and media types before
changing DNS. The local server does not interpret `_redirects`. Keep a private
backup and the previous origin until live acceptance checks are complete.
