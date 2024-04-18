//fonction pour convertir les données en objet JSON
function convertJson(data) {
	return JSON.parse(data.replace(/&quot;/g, '"'));
}
//fonction pour construire un graphique
function createChart(json, zone) {
	//création des tableaux pour les labels et les scores
	const labels = [];
	const counts = [];
	//remplissage des tableaux
	json.forEach((row) => {
		labels.push(row.firstname + " " + row.lastname);
		counts.push(row.count);
	});
	//création du graphique
	const graphique = new Chartist.Bar(
		zone,
		{
			labels: labels,
			series: counts,
		},
		{
			distributeSeries: true,
			axisY: {
				onlyInteger: true,
			},
		}
	).on("draw", function (data) {
		if (data.type === "bar") {
			data.element.attr({
				style: "stroke-width: 3%",
			});
		}
	});
}
