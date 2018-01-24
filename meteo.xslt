<?xml version="1.0" encoding="ISO-8859-1" standalone="no" ?>

<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">

  <xsl:output method="html" encoding="ISO-8859-1" indent="yes"/>

  <xsl:template match="previsions">
  	<xsl:if test="position() = last()" >
  		<p>Temperature = <xsl:value-of select="echeance/temperature/."/></p>
  		<p>Pression = <xsl:value-of select="echeance/pression/."/></p>
  		<p>Humidite = <xsl:value-of select="echeance/humidite/."/></p>
  		<p>Pluie = <xsl:value-of select="echeance/pluie/."/></p>
  		<p>Vent Moyen= <xsl:value-of select="echeance/vent_moyen/."/></p>
  		<p>Nebulosite= <xsl:value-of select="echeance/nebulosite/."/></p>
  	</xsl:if>
  	
  </xsl:template>

</xsl:stylesheet>