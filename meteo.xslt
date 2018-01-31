<?xml version="1.0" encoding="UTF-8" standalone="no" ?>

<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">

  <xsl:output method="html" encoding="UTF-8" indent="yes"/>

  <xsl:template match="/">
    <xsl:apply-templates select="//echeance"/>
  </xsl:template>
  <xsl:template match="echeance">
      <p>Temperature = <xsl:value-of select="temperature/level/. - 273.15"/> degre Celsius</p>
      <p>Pression = <xsl:value-of select="pression/."/></p>
      <p>Humidite = <xsl:value-of select="humidite/."/></p>
      <p>Pluie = <xsl:value-of select="pluie/."/></p>
      <p>Vent Moyen= <xsl:value-of select="vent_moyen/."/></p>
      <p>Nebulosite= <xsl:value-of select="/nebulosite/."/></p>

  </xsl:template>


</xsl:stylesheet>