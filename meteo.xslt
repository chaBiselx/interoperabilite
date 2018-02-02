<?xml version="1.0" encoding="UTF-8" standalone="no" ?>

<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">

  <xsl:output method="html" encoding="UTF-8" indent="yes"/>

  <xsl:template match="/">
        <table border="1">
          <th>date </th>
          <th>Temperature </th>
          <th>Pression </th>
          <th>Humidite </th>
          <th>Pluie </th>
          <th>Vent Moyen </th>
          <xsl:apply-templates select="//echeance"/>
        </table>

  </xsl:template>

  <xsl:template match="echeance">
      <tr>
        <td> <xsl:value-of select="@timestamp"/> </td>
        <td> <xsl:value-of select="temperature/level/. - 273.15"/> degre Celsius</td>
        <td> <xsl:value-of select="pression/."/></td>
        <td> <xsl:value-of select="humidite/."/></td>
        <td> <xsl:value-of select="pluie/."/></td>
        <td> <xsl:value-of select="vent_moyen/."/></td>
      </tr>
  </xsl:template>


</xsl:stylesheet>
