#!/usr/bin/env coffee

pokemon= require '/home/stephen/git/pokemon-battle-mod/index'
fs = require 'fs'

trainer1 = JSON.parse fs.readFileSync('./trainer1.json').toString()
trainer2 = JSON.parse fs.readFileSync('./trainer2.json').toString()

if trainer1["pokemon6"]["name"] 
	console.log trainer1["pokemon1"]

team1 = []
if trainer1["pokemon1"]["name"]
	poke= []
	poke.push pokemon.lookup trainer1["pokemon1"]["name"]
	poke.push trainer1["pokemon1"]["level"]
	team1.push poke
if trainer1["pokemon2"]["name"]
	poke= []
	poke.push pokemon.lookup trainer1["pokemon2"]["name"]
	poke.push trainer1["pokemon2"]["level"]
	team1.push poke
if trainer1["pokemon3"]["name"]
	poke= []
	poke.push pokemon.lookup trainer1["pokemon3"]["name"]
	poke.push trainer1["pokemon3"]["level"]
	team1.push poke
if trainer1["pokemon4"]["name"]
	poke= []
	poke.push pokemon.lookup trainer1["pokemon4"]["name"]
	poke.push trainer1["pokemon4"]["level"]
	team1.push poke
if trainer1["pokemon5"]["name"]
	poke= []
	poke.push pokemon.lookup trainer1["pokemon5"]["name"]
	poke.push trainer1["pokemon5"]["level"]
	team1.push poke
if trainer1["pokemon6"]["name"]
	poke= []
	poke.push pokemon.lookup trainer1["pokemon6"]["name"]
	poke.push trainer1["pokemon6"]["level"]
	team1.push poke

console.log team1

team2 = []
if trainer2["pokemon1"]["name"]
	poke= []
	poke.push pokemon.lookup trainer2["pokemon1"]["name"]
	poke.push trainer2["pokemon1"]["level"]
	team2.push poke
if trainer2["pokemon2"]["name"]
	poke= []
	poke.push pokemon.lookup trainer2["pokemon2"]["name"]
	poke.push trainer2["pokemon2"]["level"]
	team2.push poke
if trainer2["pokemon3"]["name"]
	poke= []
	poke.push pokemon.lookup trainer2["pokemon3"]["name"]
	poke.push trainer2["pokemon3"]["level"]
	team2.push poke
if trainer2["pokemon4"]["name"]
	poke= []
	poke.push pokemon.lookup trainer2["pokemon4"]["name"]
	poke.push trainer2["pokemon4"]["level"]
	team2.push poke
if trainer2["pokemon5"]["name"]
	poke= []
	poke.push pokemon.lookup trainer2["pokemon5"]["name"]
	poke.push trainer2["pokemon5"]["level"]
	team2.push poke
if trainer2["pokemon6"]["name"]
	poke= []
	poke.push pokemon.lookup trainer2["pokemon6"]["name"]
	poke.push trainer2["pokemon6"]["level"]
	team2.push poke
console.log team2

console.log pokemon.battle {trainer: trainer1["name"],  pokemon: team1},
                           {trainer: trainer2["name"],  pokemon: team2}

