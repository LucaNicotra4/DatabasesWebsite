<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
<xsl:template match="/">
<html> 
<body>
  <h2>My CD Collection</h2>
  <table border="1">
    <tr bgcolor="#9acd32">
      <th style="text-align:left">ID</th>
      <th style="text-align:left">LastName</th>
      <th style="text-align:left">FirstName</th>
      <th style="text-align:left">ID</th>
      <th style="text-align:left">Assignment</th>
      <th style="text-align:left">Grade</th>
    </tr>
    <xsl:for-each select="students/row">
    <tr>
      <td><xsl:value-of select="data0"/></td>
      <td><xsl:value-of select="data2"/></td>
      <td><xsl:value-of select="data4"/></td>
      <td><xsl:value-of select="data6"/></td>
      <td><xsl:value-of select="data8"/></td>
      <td><xsl:value-of select="data10"/></td>
    </tr>
    </xsl:for-each>
  </table>
</body>
</html>
</xsl:template>
</xsl:stylesheet>

