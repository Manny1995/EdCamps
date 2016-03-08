
// animals is an array of topic objects.
// Each topic object has an image and an array of question objects.
// Each question object has a question and the correct answer.
var planets =
[
	{
        name: "Earth",
		image:"earth.jpg",
		questions:
		[
				{quest:"What is the name of this planet?",answer:"Earth", done:false},
				{quest:"Does this planet support life?",answer:"Yes", done:false},
				{quest:"How many planets away from the Sun is this planet? (give a number)", answer:"3", done:false},
				{quest:"How many continents does this planet have? (Give a number)", answer:"7", done:false}
		],
        
        currentIndex: 0,
		done:false,
		score:0

	},

	{
        name: "Mars",
		image:"mars.jpg",
		questions:
		[
				{quest:"What is the name of this planet?",answer:"Mars", done:false},
				{quest:"Does this planet support life?",answer:"No", done:false},
				{quest:"How many planets away from the Sun is this planet? (give a number)", answer:"4", done:false},
				{quest:"Does this planet have water? (Yes/No)", answer:"Yes", done:false}
		],

        currentIndex: 0,
        done:false,
		score:0

	},
	{
        name: "Saturn",
		image:"saturn.jpg",
		questions:
		[
				{quest:"What is the name of this planet?",answer:"Saturn", done:false},
				{quest:"Does this planet support life?",answer:"No", done:false},
				{quest:"How many planets away from the Sun is this planet? (give a number)", answer:"7", done:false},	
            {quest:"How many rings does this planet have? (give a number)", answer:"4", done:false}

		],
        currentIndex: 0,
        done:false,
		score:0

	},

	{
        name: "Pluto",
		image:"pluto.jpg",
		questions:
		[
			{quest:"What is the name of this planet?",answer:"Pluto", done:false},
			{quest:"Does this planet support life?",answer:"No", done:false},
			{quest:"How many planets away from the Sun is this planet? (give a number)", answer:"9", done:false},
			{quest:"Is this planet a planet?", answer:"No", done:false}
		],

        currentIndex: 0,
        done:false,
		score:0

	}
];

