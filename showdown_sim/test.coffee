#!/usr/bin/env coffee

pokemon = require '/home/egilmore/git/pokemon-battle/index'
fs = require 'fs'

trainer1 = JSON.parse fs.readFileSync('./trainer1.json').toString()
trainer2 = JSON.parse fs.readFileSync('./trainer2.json').toString()

team1 = []
team1.push pokemon.lookup trainer1["pokemon1"]["name"]
team1.push pokemon.lookup trainer1["pokemon2"]["name"]
team1.push pokemon.lookup trainer1["pokemon3"]["name"]
team1.push pokemon.lookup trainer1["pokemon4"]["name"]
team1.push pokemon.lookup trainer1["pokemon5"]["name"]
team1.push pokemon.lookup trainer1["pokemon6"]["name"]

console.log team1


team2 = []
team2.push pokemon.lookup trainer2["pokemon1"]["name"]
team2.push pokemon.lookup trainer2["pokemon2"]["name"]
team2.push pokemon.lookup trainer2["pokemon3"]["name"] 
team2.push pokemon.lookup trainer2["pokemon4"]["name"] 
team2.push pokemon.lookup trainer2["pokemon5"]["name"] 
team2.push pokemon.lookup trainer2["pokemon6"]["name"]

console.log team2

console.log pokemon.battle {trainer: trainer1["name"],  pokemon: [team1]},
                           {trainer: trainer2["name"],  pokemon: [team2[0], team2[1], team2[2], team2[3], team2[4], team2[5]]}

