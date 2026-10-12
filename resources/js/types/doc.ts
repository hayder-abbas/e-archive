import { Box } from "./box";
import { Entity } from "./entity";

export type Doc = {
    id: number;
    number: string;
    subject: string;
    date: string;
    type: string;
    security: string;
    description: string;
    box?: Box;
    entity?: Entity;
};
