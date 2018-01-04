import os
from xml.sax.saxutils import escape

xmlFile = '<?xml version="1.0" encoding="UTF-8"?>\n<playlist version="1" xmlns="http://xspf.org/ns/0">\n<trackList>\n'
for mp3 in sorted(os.listdir("/var/www/html/mp3")):
    if(os.path.splitext(mp3)[1] != ".webm"):
        escaped = escape(mp3)
        escapedNoExtension = escape(os.path.splitext(mp3)[0])
        xmlFile += '<track>\n'
        xmlFile += '<creator></creator>\n'
        xmlFile += '<title>' + escapedNoExtension + '</title>\n'
        xmlFile += '<location>../mp3/' + escaped + '</location>\n'
        xmlFile += '</track>\n'

xmlFile += '</trackList>\n</playlist>'

outputFile = open("/var/www/html/vip/roster.xml", "w")
outputFile.write(xmlFile)
