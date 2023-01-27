import test from 'ava';

const bibtexParse = require('../bibtexParse');

const input = `
	@article{
	  author = {Huang, Y. and Mucke, L.},
	  title = {Alzheimer mechanisms and therapeutic strategies},
	  journal = {Cell},
	  volume = {148},
	  number = {6},
	  pages = {1204-22},
	  note = {Huang, Yadong
	Mucke, Lennart
	AG011385/AG/NIA NIH HHS/
	AG022074/AG/NIA NIH HHS/
	Cell. 2012 Mar 16;148(6):1204-22.},
	  abstract = {There are still no effective treatments to prevent, halt, or reverse Alzheimer's disease, but research advances over the past three decades could change this gloomy picture. Genetic studies demonstrate that the disease has multiple causes. Interdisciplinary approaches combining biochemistry, molecular and cell biology, and transgenic modeling have revealed some of its molecular mechanisms. Progress in chemistry, radiology, and systems biology is beginning to provide useful biomarkers, and the emergence of personalized medicine is poised to transform pharmaceutical development and clinical trials. However, investigative and drug development efforts should be diversified to fully address the multifactoriality of the disease.},
	  year = {2012}
	}
`;

const output = [ { citationKey: 'Huang, 2012',
    entryType: 'article',
    entryTags:
     { author: 'Huang, Y. and Mucke, L.',
       title: 'Alzheimer mechanisms and therapeutic strategies',
       journal: 'Cell',
       volume: '148',
       number: '6',
       pages: '1204-22',
       note: 'Huang, Yadong\n\tMucke, Lennart\n\tAG011385/AG/NIA NIH HHS/\n\tAG022074/AG/NIA NIH HHS/\n\tCell. 2012 Mar 16;148(6):1204-22.',
       abstract: 'There are still no effective treatments to prevent, halt, or reverse Alzheimer\'s disease, but research advances over the past three decades could change this gloomy picture. Genetic studies demonstrate that the disease has multiple causes. Interdisciplinary approaches combining biochemistry, molecular and cell biology, and transgenic modeling have revealed some of its molecular mechanisms. Progress in chemistry, radiology, and systems biology is beginning to provide useful biomarkers, and the emergence of personalized medicine is poised to transform pharmaceutical development and clinical trials. However, investigative and drug development efforts should be diversified to fully address the multifactoriality of the disease.',
       year: '2012' } } ];

test('Endnote should parse', t => t.deepEqual(output, bibtexParse.toJSON(input)));
