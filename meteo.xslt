<?xml version="1.0" encoding="ISO-8859-1" standalone="no" ?>

<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">

  <xsl:output method="html" encoding="ISO-8859-1" indent="yes"/>

  <xsl:template match="echeance">
  	<p>Température = <xsl:value-of select="temperature/."/></p>
  	<p>Pression = <xsl:value-of select="pression/."/></p>
  	<p>Humidite = <xsl:value-of select="humidite/."/></p>
  </xsl:template>

</xsl:stylesheet>