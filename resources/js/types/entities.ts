import { Links, Meta } from "./paginate";

export type Entity = {
    id: number;
    name: string;
};

export type Entities = {
    data: Entity[];
    links: Links;
    meta: Meta;
};
