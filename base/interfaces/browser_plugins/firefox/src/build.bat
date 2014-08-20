set x=twickit
md build\chrome
cd chrome
7z a -tzip "%x%.jar" * -r -mx=0
move "%x%.jar" ..\build\chrome
cd ..
copy install.rdf build
copy chrome.manifest build
cd build
7z a -tzip "%x%.xpi" * -r -mx=9
move "%x%.xpi" ..\
cd ..
rd build /s/q
