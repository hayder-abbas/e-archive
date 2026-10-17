import { Box } from "./boxes";
import { Entity } from "./entities";
import { Links, Meta } from "./paginate";

export type Document = {
    id: number;
    number: string;
    subject: string;
    date: string;
    file: string;
    type: string;
    security: string;
    description: string;
    box?: Box;
    entity?: Entity;
};

export type Documents = {
    data: Document[];
    links: Links;
    meta: Meta;
};
