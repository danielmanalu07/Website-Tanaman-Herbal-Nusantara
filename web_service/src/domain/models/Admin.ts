import { DataTypes, Model, Optional } from "sequelize";
import connection from "../../infrastructure/config/dbConnect";
import Staff from "./Staff";

interface AdminAttributes {
  id?: number;
  username?: string | null;
  password?: string | null;
  accessToken?: string | null;

  createdAt?: Date;
  updatedAt?: Date;
}

export interface AdminInput extends Optional<AdminAttributes, "id"> {}
export interface AdminOutput extends Required<AdminAttributes> {}

class Admin
  extends Model<AdminAttributes, AdminInput>
  implements AdminAttributes
{
  public id!: number;
  public username!: string;
  public password!: string;
  public accessToken!: string;

  public readonly createdAt!: Date;
  public readonly updatedAt!: Date;
}

Admin.init(
  {
    id: {
      allowNull: false,
      primaryKey: true,
      autoIncrement: true,
      type: DataTypes.BIGINT,
    },
    username: {
      allowNull: true,
      type: DataTypes.STRING,
    },
    password: {
      allowNull: true,
      type: DataTypes.STRING,
    },
    accessToken: {
      allowNull: true,
      type: DataTypes.TEXT,
    },
  },
  {
    timestamps: true,
    sequelize: connection,
    underscored: false,
  }
);

// Admin.hasMany(Staff, { foreignKey: "adminId", as: "staffs" });

export default Admin;
