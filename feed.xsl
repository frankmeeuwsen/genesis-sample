<?xml version="1.0" encoding="utf-8"?>
<xsl:stylesheet version="3.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform" xmlns:atom="http://www.w3.org/2005/Atom" xmlns:dc="http://purl.org/dc/elements/1.1/" xmlns:itunes="http://www.itunes.com/dtds/podcast-1.0.dtd">
  <xsl:output method="html" version="1.0" encoding="UTF-8" indent="yes"/>
  <xsl:template match="/">
    <html xmlns="http://www.w3.org/1999/xhtml">
      <head>
        <title><xsl:value-of select="/rss/channel/title"/> RSS Feed</title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1"/>
        <meta charset="UTF-8"/>
        <!-- <link rel="stylesheet" href="/wp-content/themes/dtd/feed.css"/> -->
        <style>
        body {
  max-width: 960px;
  margin: 0 auto;
  padding: 24px 12px 48px 12px;
  text-rendering: optimizeLegibility;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  color: black;
  font: 20px/1.4 system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial, "Noto Sans", "Liberation Sans", sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji";
}
.head {
  display: flex;
  flex: wrap;
  align-items: center;
  justify-content: start;
  margin-bottom: 48px;
}
.avatar {
  padding-right: 20px;
}
.description {
  flex-grow: 1;
  padding-left: 20px;
  border-left: 1px solid #E6E6E6;
}
article {
  padding-bottom: 20px;
  border-bottom: 2px solid #E6E6E6;
}
h2 {
  margin-bottom: 36px;
}
h3 {
  font-size: 22px;
}
footer {
  font-size: 16px;
  color: #777;
}
.rss-logo {
  width: 30px;
  height: 30px;
  padding-right: 8px;
}
.aboutfeeds {
  font-size: 16px;
  background-color: #F5F5F5;
  margin: 20px 0 40px 0;
  padding: 4px 20px;
}
.about {
  margin-top: 40px;
  font-size: 16px;
}
.about img {
  padding-right: 8px;
  vertical-align: middle;
}

        </style>
      </head>
      <body>
        <header>
          <h1><svg class="rss-logo" xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 256 256"><defs><linearGradient x1=".085" y1=".085" x2=".915" y2=".915" id="a"><stop offset="0" stop-color="#E3702D"/><stop offset=".107" stop-color="#EA7D31"/><stop offset=".35" stop-color="#F69537"/><stop offset=".5" stop-color="#FB9E3A"/><stop offset=".702" stop-color="#EA7C31"/><stop offset=".887" stop-color="#DE642B"/><stop offset="1" stop-color="#D95B29"/></linearGradient></defs><rect width="256" height="256" rx="55" ry="55" fill="#CC5D15"/><rect width="246" height="246" rx="50" ry="50" x="5" y="5" fill="#F49C52"/><rect width="236" height="236" rx="47" ry="47" x="10" y="10" fill="url(#a)"/><circle cx="68" cy="189" r="24" fill="#FFF"/><path d="M160 213h-34a82 82 0 0 0-82-82V97a116 116 0 0 1 116 116z" fill="#FFF"/><path d="M184 213A140 140 0 0 0 44 73V38a175 175 0 0 1 175 175z" fill="#FFF"/></svg><xsl:value-of select="/rss/channel/title"/></h1>
          <div class="aboutfeeds">
            <p>This is a web feed, also known as an RSS feed. <strong>Subscribe</strong> by copying the URL into your RSS reader. To know more read <a href="https://aboutfeeds.com/" target="_blank"><strong>About Feeds</strong></a> by Matt Webb.</p>

          </div>
          <div class="head">
            <div class="avatar">
              <img src="/wp-content/uploads/cropped-dtd-logo-64x64.jpg" alt="Avatar of Simone Silvestroni"/>
            </div>
            <div class="description">
              <p><xsl:value-of select="/rss/channel/description"/></p>
              <p><a hreflang="en"><xsl:attribute name="href"><xsl:value-of select="/rss/channel/link"/></xsl:attribute>Visit Website &#x2192;</a></p>
            </div>
          </div>
        </header>
        <main>
          <h2>📄 Recent Posts</h2>
          <xsl:for-each select="/rss/channel/item">
            <article>
              <h3><a hreflang="en" target="_blank"><xsl:attribute name="href"><xsl:value-of select="link"/></xsl:attribute><xsl:value-of select="title"/></a></h3>
              <!-- <p><xsl:value-of select="description"/></p> -->
              <footer>Published: <time><xsl:value-of select="pubDate" /></time></footer>
            </article>
          </xsl:for-each>
          <!-- <p class="about"><img src="/assets/images/favicons/favicon.svg" alt="Minutes to Midnight icon" width="24" height="24" /><a href="https://minutestomidnight.co.uk/about/">About Simone Silvestroni</a> (Minutes to Midnight).</p> -->
        </main>
      </body>
    </html>
  </xsl:template>
</xsl:stylesheet>
