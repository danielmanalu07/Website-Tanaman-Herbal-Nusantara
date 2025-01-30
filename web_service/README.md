#Installation
npm init --y
npm install -g typescript
tsc --init
npm install ts-node nodemon typescript -D
npm install express dotenv
npm i --save-dev @types/express
npm install --save sequelize mysql2
npm install --save-dev sequelize-cli
npx sequelize-cli init
npm install bcrypt
npm i --save-dev @types/bcrypt
npm install validatorjs
npm i --save-dev @types/validatorjs
npm install jsonwebtoken cookie-parser
npm install @types/jsonwebtoken @types/cookie-parser -D

#Migration, Model, Seeder
npx sequelize-cli model:generate --name Admin --attributes username:string,password:string
npx sequelize-cli db:migrate
npx sequelize-cli seed:generate --name AdminSeeder
npx sequelize-cli db:seed:all
