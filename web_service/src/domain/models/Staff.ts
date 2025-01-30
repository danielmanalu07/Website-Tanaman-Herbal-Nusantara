import { DataTypes, Model, Optional } from "sequelize";
import connection from "../../infrastructure/config/dbConnect";
import Admin from "./Admin";

interface StaffAttributes {
  id?: number;
  username?: string | null;
  password?: string | null;
  accessToken?: string | null;
  active?: boolean | null;
  adminId?: number | undefined;

  createdAt?: Date;
  updatedAt?: Date;
}

export interface StaffInput extends Optional<StaffAttributes, "id"> {}
export interface StaffOutput extends Required<StaffAttributes> {}

class Staff
  extends Model<StaffAttributes, StaffInput>
  implements StaffAttributes
{
  public id!: number;
  public username!: string;
  public password!: string;
  public accessToken!: string;
  public active!: boolean;
  public adminId!: number;

  public readonly createdAt!: Date;
  public readonly updatedAt!: Date;
}

Staff.init(
  {
    id: {
      allowNull: false,
      primaryKey: true,
      autoIncrement: true,
      type: DataTypes.BIGINT,
    },
    username: {
      allowNull: false,
      type: DataTypes.STRING,
    },
    password: {
      allowNull: false,
      type: DataTypes.STRING,
    },
    accessToken: {
      allowNull: true,
      type: DataTypes.STRING,
    },
    active: {
      allowNull: false,
      type: DataTypes.BOOLEAN,
    },
    adminId: {
      allowNull: false,
      type: DataTypes.BIGINT,
      references: {
        model: Admin,
        key: "id",
      },
    },
  },
  {
    timestamps: true,
    sequelize: connection,
    underscored: false,
  }
);

// Staff.belongsTo(Admin, { foreignKey: "adminId", as: "admins" });

export default Staff;
