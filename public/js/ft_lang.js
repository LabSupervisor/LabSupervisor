let langData;
var useLang = userLang || defaultLang;

fetch("/public/lang/" + useLang + ".json")
	.then(response => response.json())
	.then(data => {
		langData = data;
	})
	.catch(error => console.error('Error fetching language data:', error));

function lang(key) {
	return langData[key];
}
