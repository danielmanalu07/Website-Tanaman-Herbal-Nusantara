import express from "express";
import dotenv from "dotenv";
import cookieParser from "cookie-parser";
import router from "../../interfaces/routes/Route";

dotenv.config();

const app = express();
app.use(express.json());
app.use(cookieParser());

app.use("/api", router);

app.listen(process.env.APP_PORT, () => {
  console.log(
    `${process.env.APP_NAME} running on port ${process.env.APP_PORT}`
  );
});
