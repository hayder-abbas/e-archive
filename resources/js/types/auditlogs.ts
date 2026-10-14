import { Links, Meta } from "./paginate";

export type AuditLog = {
    id: number;
    userId: number;
    username: string;
    action: string;
    targetType: string;
    targetNumber: string;
    createdAt: string;
    updatedAt: string;
};

export type AuditLogs = {
    data: AuditLog[];
    links: Links;
    meta: Meta;
};
