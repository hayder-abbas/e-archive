import { Box } from "./boxes";
import { Entity } from "./entities";
import { Links, Meta } from "./paginate";

export type Document = {
    id: number;
    number: string;
    date: string;
    subject: string;
    file: string | null;
    type: string;
    security: string;
    belongsTo: string;
    notes: string;
    revokedAt: string;
    box?: Box;
    entity?: Entity;
};

export type OverView = {
    archived: number;
    borrow: number;
    incoming: number;
    outgoing: number;
};

export type Documents = {
    data: Document[];
    links: Links;
    meta: Meta;
};
